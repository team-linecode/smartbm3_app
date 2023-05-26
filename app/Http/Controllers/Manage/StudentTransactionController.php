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
                ->orderByRaw("FIELD(status, 'pending') DESC")
                ->get()
        ]);
    }

    public function create()
    {
        return view('manage.student_transaction.create', [
            'user' => User::find(auth()->user()->id),
            'items' => TransactionItem::where('user_id', auth()->user()->id)->get()
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

        return back()->with('success', 'Item berhasil disimpan. Silahkan lanjutkan pembayaran');
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
        if ($this->get_items()['all']->isEmpty()) {
            return redirect()->route('app.transaction.create')->with('error', 'Silahkan pilih pembayaran');
        }

        $user = User::findOrFail(auth()->user()->id);
        $client = new Client();

        // $response = $client->post('https://bigflip.id/api/v2/pwf/bill', [
        $response = $client->post('https://bigflip.id/big_sandbox_api/v2/pwf/bill', [
            'auth' => [$this->secret_key . ':', ''],
            'form_params' => [
                'title' => 'Pembayaran Sekolah',
                'amount' => $this->get_items()['total'],
                'type' => 'SINGLE',
                'expired_date' => date('Y-m-d H:i', time() + (60 * 60 * 48)), // 2 days
                'redirect_url' => 'https://smartbm3.com/',
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
                'status' => 'Pending',
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

            return redirect()->away('https://' . $trx->bill_url);
        } else {
            return redirect()->route('app.transaction.create')->with('error', 'Sedang tidak dapat melakukan transaksi, Silahkan coba beberapa waktu lagi');
        }
    }

    public function confirm()
    {
        
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
}
