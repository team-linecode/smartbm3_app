<?php

namespace App\Http\Controllers\Manage;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use App\Models\Cost;
use GuzzleHttp\Exception\RequestException;

class StudentTransactionController extends Controller
{
    private $secret_key;

    public function __construct()
    {
        $this->secret_key = env('FLIP_SECRET_KEY');
    }

    public function index()
    {
        return view('manage.student_transaction.index', [
            'transactions' => Transaction::where('user_id', auth()->user()->id)
                // ->orderByRaw("FIELD(status, 'pending') DESC")
                ->orderByDesc('created_at')
                ->get()
        ]);
    }

    public function choose_student()
    {
        return view('manage.student_transaction.choose_student');
    }

    public function create()
    {
        // jika rolenya finance
        if (auth()->user()->hasRole('finance')) {
            // jika tidak ada request get uuid
            if (!request()->get('uuid')) {
                // alihkan ke route choose_student
                return redirect()->route('app.transaction.choose_student');
            }
            // ambil user dari data uuid
            $user = User::where('uuid', request()->get('uuid'))->first();
            // jika tidak ditemukan
            if (!$user) {
                // alihkan ke route choose_student
                return redirect()->route('app.transaction.choose_student')->with('error', 'Siswa tidak ditemukan');
            }
        } else {
            // ambil data user dari login saat ini
            $user = User::find(auth()->user()->id);
            // jika tidak ditemukan
            if (!$user) {
                // alihkan ke route choose_student
                return redirect()->route('app.transaction.choose_student')->with('error', 'Siswa tidak ditemukan');
            }
        }

        return view('manage.student_transaction.create', [
            'user' => $user,
            'items' => TransactionItem::where('user_id', $user->id)->get()
        ]);
    }

    public function create_step2(Cost $cost)
    {
        // jika rolenya finance
        if (auth()->user()->hasRole('finance')) {
            // jika tidak ada request get uuid
            if (!request()->get('uuid')) {
                // alihkan ke route choose_student
                return redirect()->route('app.transaction.choose_student');
            }
            // ambil user dari data uuid
            $user = User::where('uuid', request()->get('uuid'))->first();
            // jika tidak ditemukan
            if (!$user) {
                // alihkan ke route choose_student
                return redirect()->route('app.transaction.choose_student')->with('error', 'Siswa tidak ditemukan');
            }
        } else {
            // ambil data user dari login saat ini
            $user = User::find(auth()->user()->id);
            // jika tidak ditemukan
            if (!$user) {
                // alihkan ke route choose_student
                return redirect()->route('app.transaction.choose_student')->with('error', 'Siswa tidak ditemukan');
            }
        }

        $where = [];
        if ($cost->cost_category->slug == 'ujian') {
            $where['key'] = 'semester_id';
            $where['value'] = $cost->getSemesterByClass();
        } else if ($cost->cost_category->slug == 'spp') {
            $classroom = auth()->user()->classroom->alias;
            $where['key'] = 'classroom_id';
            $where['value'] = $classroom == '10' ? [1] : ($classroom == '11' ? [1, 2] : [1, 2, 3]);
        } else if ($cost->cost_category->slug == 'daftar-ulang') {
            $classroom = auth()->user()->classroom->alias;
            $where['key'] = 'classroom_id';
            $where['value'] = $classroom == '10' ? [] : ($classroom == '11' ? [1, 2] : [1, 2, 3]);
        }

        return view('manage.student_transaction.create_step2', [
            'where' => $where,
            'cost' => $cost,
            'user' => $user,
            'items' => TransactionItem::where('user_id', auth()->user()->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->costs) {
            return back()->with('error', 'Silahkan pilih pembayaran');
        }

        // get user
        $user = User::where('id', auth()->user()->id)->firstOrFail();
        // end get user

        // create transaction detail
        foreach ($request->costs as $i => $cost) {
            // declare variable
            $cost_category = $i;

            foreach ($cost as $j => $detail) {

                if ($cost_category == 'ujian' || $cost_category == 'daftar-ulang' || $cost_category == 'gedung' || $cost_category == 'lain-lain') {
                    if (cleanCurrency($detail['amount']) < 50000) {
                        return back()->with('error', 'Minimum pembayaran tidak boleh dibawah Rp50.000');
                    }

                    $item = TransactionItem::create([
                        'amount' => cleanCurrency($detail['amount']),
                        'cost_detail_id' => $detail['cost_detail_id'],
                    ]);
                    $item->user_id = $user->id;
                    $item->save();
                }

                if ($cost_category == 'spp') {
                    foreach ($detail as $month => $d) {
                        if (cleanCurrency($d['amount']) < 50000) {
                            return back()->with('error', 'Minimum pembayaran tidak boleh dibawah Rp50.000');
                        }

                        $item = TransactionItem::create([
                            'amount' => cleanCurrency($d['amount']),
                            'month' => getSPPdate($j, $user->schoolyear_id, $month),
                            'cost_detail_id' => $d['cost_detail_id'],
                        ]);
                        $item->user_id = $user->id;
                        $item->save();
                    }
                }
            }
        }
        // end create transaction detail

        return redirect()->route('app.transaction.success_saved')->with('success', 'Item berhasil disimpan. Silahkan lanjutkan pembayaran');
    }

    public function success_saved()
    {
        $items = TransactionItem::where('user_id', auth()->user()->id)->get();
        if ($items->count() < 1) {
            return redirect()->route('app.transaction.create')->with('error', 'Silahkan tambahkan transaksi');
        }

        return view('manage.student_transaction.success_saved');
    }

    public function maintenance()
    {
        if (!$this->is_maintenance()) {
            return redirect()->route('app.transaction.create')->with('success', 'Transaksi Normal! Silahkan Melakukan Pembayaran');
        }

        return view('manage.student_transaction.maintenance');
    }

    public function detail()
    {
        return view('manage.student_transaction.detail', [
            'items' => TransactionItem::where('user_id', auth()->user()->id)->get()
        ]);
    }

    public function delete_item(TransactionItem $transaction_item)
    {
        if ($transaction_item->user_id == auth()->user()->id) {
            $transaction_item->delete();

            return back()->with('success', 'Item berhasil dihapus');
        }

        abort('404');
    }

    public function payment()
    {
        if ($this->is_maintenance()) {
            return redirect()->route('app.transaction.maintenance');
        }

        if ($this->get_items()['all']->isEmpty()) {
            return redirect()->route('app.transaction.create')->with('error', 'Silahkan pilih pembayaran');
        }

        $user = User::findOrFail(auth()->user()->id);

        // $response = $client->post('https://bigflip.id/api/v2/pwf/bill', [
        $response = $client->post('https://bigflip.id/big_sandbox_api/v2/pwf/bill', [
            'auth' => [$this->secret_key . ':', ''],
            'form_params' => [
                'title' => 'Pembayaran Sekolah',
                'amount' => $this->get_items()['total'],
                'type' => 'SINGLE',
                'expired_date' => date('Y-m-d H:i', time() + (60 * 60 * 48)), // 2 days
                'redirect_url' => 'https://smartbm3.com/app/my/transaction',
                'is_address_required' => 0,
                'is_phone_number_required' => 0,
                'step' => 2,
                'sender_name' => $user->name,
                'sender_email' => $user->email ?? 'example@smartbm3.com',
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents(), true);

            // create transaction
            $current_trx = !is_null($trx = Transaction::latest()->first()) ? $trx->invoice_no : 0;
            $trx = Transaction::create([
                'invoice_no' => (str_pad((int) $current_trx + 1, 4, '0', STR_PAD_LEFT)),
                'invoice_id' => 'BMM' . rand(11111111, 99999999),
                'status' => 'Unpaid',
                'date' => Carbon::now()->format('Y-m-d H:i:s'),
                'user_id' => $user->id
            ]);
            $trx->bill_id = $data['link_id'];
            $trx->bill_url = $data['link_url'];
            $trx->total = $this->get_items()['total'];
            $trx->save();
            // end create transaction

            // create transaction detail
            foreach ($this->get_items()['all'] as $item) {
                TransactionDetail::create([
                    'amount' => $item->amount,
                    'month' => $item->month ?? null,
                    'cost_detail_id' => $item->cost_detail_id,
                    'transaction_id' => $trx->id
                ]);
            }
            // end create transaction detail

            // delete items
            TransactionItem::where('user_id', auth()->user()->id)->delete();
            // end delete items

            // Notifikasi Whatsapp
            $url = 'https://wagate.biz.id/send-message';
            $sender = '62881026026420';
            $receiver = '6285156465410';
            $message = "Hai " . $user->name . ", pembayaran berhasil dibuat.\n";
            $message .= "Lakukan pembayaran melalui tautan berikut :\n";
            $message .= "https://" . $trx->bill_url . "\n\n\n";
            $message .= "note:\nHati-hati modus penipuan!\nharap abaikan pesan ini jika tidak merasa melakukan pembayaran ini\n\n";
            $message .= "pesan ini hanya dikirim dari whatsapp staff keuangan SMK Bina Mandiri Multimedia";

            $responseWa = wagate($url, $sender, $receiver, $message);
            if ($responseWa->getStatusCode() != 200) {
                $responseWa;
            }
            // End Notifikasi WhatsApp

            // Notifikasi Email
            $urlEmail = 'https://mailportal.biz.id/api/sendmail';
            $responseMail = $client->post($urlEmail, [
                'form_params' => [
                    'from_email' => 'noreply@wellco.id',
                    'from_name' => 'SmartBM3',
                    'to_email' => 'rioadrian646@gmail.com',
                    'subject' => 'Pembayaran Sekolah',
                    // 'files' => [
                    //     'https://puriamalaasri.site/files/brosur-puriamalaasri.pdf'
                    // ],
                    'body' => view('emails.paymentLink', [
                        'data' => [
                            'name' => $user->name,
                            'link' => 'https://' . $trx->bill_url
                        ]
                    ])->render(),
                    'key' => 'b803b755b26e0d171c6037ba6187ee36395ee59371c52c8633b30f5105764316',
                ],
            ]);
            if ($responseMail->getStatusCode() != 200) {
                $responseMail;
            }
            // End Notifikasi Email

            return redirect()->away('https://' . $trx->bill_url);
        } else {
            return redirect()->route('app.transaction.create')->with('error', 'Sedang tidak dapat melakukan transaksi, Silahkan coba beberapa waktu lagi');
        }
    }

    public function confirm(Request $request)
    {
        // Proses data callback yang diterima
        $data = json_decode($request->all()['data']);

        if ($data->status == 'SUCCESSFUL') {
            $trx = Transaction::where('bill_id', $data->bill_link_id)->first();
            $trx->status = 'Paid';
            $trx->update();
        }

        // Notifikasi Whatsapp
        $url = 'https://wagate.biz.id/send-message';
        $sender = '62881026026420';
        $receiver = '6285156465410';
        $message = "Hai " . $data->sender_name . ", pembayaran telah kami terima.\n";
        $message .= "Terimakasih telah melakukan pembayaran.\n";
        $message .= "Jangan lupa untuk melakukan pembayaran tepat waktu.\n";
        $message .= "note:\nHati-hati modus penipuan!\nharap abaikan pesan ini jika tidak merasa melakukan pembayaran ini\n\n";
        $message .= "pesan ini hanya dikirim dari whatsapp staff keuangan SMK Bina Mandiri Multimedia";

        $responseWa = wagate($url, $sender, $receiver, $message);
        if ($responseWa->getStatusCode() != 200) {
            $responseWa;
        }
        // End Notifikasi WhatsApp

        return redirect()->route('app.transaction.index');
    }

    public function get_items()
    {
        $transaction_items = TransactionItem::where('user_id', auth()->user()->id)->get();
        // dd($transaction_items->average('amount'));

        if (!$transaction_items) {
            return [];
        } else {
            return [
                'all' => $transaction_items,
                'total' => $transaction_items->sum('amount'),
                'rows' => $transaction_items->count(),
                'min' => $transaction_items->min('amount'),
                'max' => $transaction_items->max('amount'),
            ];
        }
    }

    private function is_maintenance()
    {
        $client = new Client();
        $response = $client->get('https://bigflip.id/api/v2/general/maintenance', [
            'auth' => [$this->secret_key . ':', ''],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true)['maintenance'];
    }
}
