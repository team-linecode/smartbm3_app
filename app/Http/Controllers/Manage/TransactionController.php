<?php

namespace App\Http\Controllers\Manage;

use PDF;
use App\Models\Cost;
use App\Models\User;
use App\Models\Month;
use App\Models\CostDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $this->authorize('read transaction');

        return view('manage.finance.transaction.index', [
            'users' => User::role('student')->get(),
            'transactions' => Transaction::latest()->get()
        ]);
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('read transaction');

        return view('manage.finance.transaction.show', [
            'users' => User::role('student')->get(),
            'transaction' => $transaction
        ]);
    }

    public function create()
    {
        $this->authorize('create transaction');

        return view('manage.finance.transaction.create', [
            'users' => User::role('student')->get(),
            'payment_methods' => PaymentMethod::all()
        ]);
    }

    public function save_transaction(Request $request)
    {
        $this->authorize('create transaction');

        $request->validate([
            'date' => 'required',
            'invoice_id' => 'unique:transactions,invoice_id'
        ]);

        $latest = !is_null($trx = Transaction::latest()->first()) ? $trx->invoice_no : 0;
        $trans = Transaction::create([
            'invoice_no' => (str_pad((int) $latest + 1, 4, '0', STR_PAD_LEFT)),
            'invoice_id' => str_replace('#', '', $request->invoice_id),
            'user_id' => $request->user_id,
            'date' => $request->date
        ]);

        return redirect(route('app.finance.transaction.create_detail', $trans->id));
    }

    public function update_transaction(Transaction $transaction, Request $request)
    {
        $this->authorize('update transaction');

        $request->validate(
            [
                'transaction_date' => 'required',
                'status' => 'required',
                'payment_method_id' => 'required'
            ],
            [
                'transaction_date.required' => 'Pilih tanggal transaksi',
                'transaction_date.date' => 'Harap memasukkan tanggal yang valid',
                'status.required' => 'Pilih status transaksi',
                'payment_method_id.required' => 'Pilih metode pembayaran'
            ]
        );

        $transaction->date = $request->transaction_date;
        $transaction->update($request->all());

        return back()->with('success', 'Transaksi berhasil disimpan');
    }

    public function create_detail(User $user)
    {
        $this->authorize('create transaction');

        return view('manage.finance.transaction.create', [
            'user' => $user,
            'users' => User::role('student')->get(),
            'cost_spp' => Cost::where('schoolyear_id', $user->schoolyear_id)->whereHas('cost_category', function ($query) {
                $query->where('slug', 'spp');
            })->first(),
            'months' => Month::all(),
            'payment_methods' => PaymentMethod::where('status', 'active')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create transaction');

        $request->validate([
            'user' => 'required',
            'note' => 'max:255',
            'status' => 'required',
            'date' => 'required|date',
            'payment_method' => 'required'
        ]);

        if (!$request->costs) {
            return back()->with('error', 'Silahkan pilih pembayaran');
        }

        // get user
        $user = User::where('username', $request->user)->firstOrFail();
        // end get user

        // create transaction
        $current_trx = !is_null($trx = Transaction::latest()->first()) ? $trx->invoice_no : 0;
        $trx = Transaction::create([
            'invoice_no' => (str_pad((int) $current_trx + 1, 4, '0', STR_PAD_LEFT)),
            'invoice_id' => 'BMM' . rand(11111111, 99999999),
            'status' => $request->status,
            'date' => $request->date,
            'note' => $request->note ?? null,
            'user_id' => $user->id,
            'payment_method_id' => $request->payment_method ?? null,
        ]);
        // end create transaction

        // create transaction detail
        $total = 0;
        foreach ($request->costs as $i => $cost) {
            // declare variable
            $cost_category = $i;

            foreach ($cost as $j => $detail) {
                if ($cost_category == 'ujian' || $cost_category == 'daftar-ulang' || $cost_category == 'gedung' || $cost_category == 'lain-lain') {
                    $total += cleanCurrency($detail['amount']);
                    TransactionDetail::create([
                        'amount' => cleanCurrency($detail['amount']),
                        'cost_detail_id' => $detail['cost_detail_id'],
                        'transaction_id' => $trx->id
                    ]);
                }

                if ($cost_category == 'spp') {
                    foreach ($detail as $month => $d) {
                        $total += cleanCurrency($d['amount']);
                        TransactionDetail::create([
                            'amount' => cleanCurrency($d['amount']),
                            'month' => getSPPdate($j, $user->schoolyear_id, $month),
                            'cost_detail_id' => $d['cost_detail_id'],
                            'transaction_id' => $trx->id
                        ]);
                    }
                }
            }
        }
        $trx->total = $total;
        $trx->update();
        // end create transaction detail

        return back()->with('success', 'Transaksi berhasil disimpan');
    }

    public function detail_destroy(TransactionDetail $transaction_detail)
    {
        $this->authorize('delete transaction');

        // update transaction total
        $transaction = Transaction::find($transaction_detail->transaction->id);
        $transaction->total -= $transaction_detail->amount;
        $transaction->update();

        // delete transaction detail
        $transaction_detail->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function get_user(Request $request)
    {
        $this->authorize('read transaction');

        $user = User::where('id', $request->user_id)
            ->with('classroom')
            ->with('expertise')
            ->with('schoolyear')
            ->first();

        $cost_options = '<option value="" hidden>Pilih Biaya</option>';

        foreach ($user->schoolyear->costs as $cost) {
            $cost_options .= '<option value="' . $cost->id . '">' . $cost->name . '</option>';
        }

        return response()->json([
            'user' => $user,
            'costs' => $cost_options
        ]);
    }

    public function get_cost_schoolyear(Request $request)
    {
        $this->authorize('read transaction');

        return response()->json(['status' => 200]);
    }

    public function get_cost_detail(Request $request)
    {
        $this->authorize('read transaction');

        $cost = Cost::find($request->cost_id);
        $user = User::find($request->user_id);
        $el = '<option value="" hidden>- Pilih Detail -</option>';

        if ($cost->cost_category->slug != 'gedung') {
            foreach ($cost->details as $cost_detail) {
                $el .= '<option value="' . $cost_detail->id . '">';
                if ($cost->cost_category->slug == 'spp') {
                    $el .= 'Kelas ' . $cost_detail->classroom->alias;
                } else if ($cost->cost_category->slug == 'ujian') {
                    $el .= 'Semester ' . $cost_detail->semester->number;
                } else if ($cost->cost_category->slug == 'daftar-ulang') {
                    $el .= 'Kelas ' . $cost_detail->classroom->alias;
                }
                $el .= '</option>';
            }
        } else {
            foreach ($cost->cost_groups($user->group->id) as $cost_detail) {
                $el .= '<option value="' . $cost_detail->id . '" selected>';
                $el .= 'Gelombang ' . $cost_detail->group->number;
                $el .= '</option>';
                $amount = $cost_detail->amount;
            }
        }

        return response()->json([
            'el' => $el,
            'cost_category' => $cost->cost_category->slug,
            'amount' => isset($amount) ? $amount : 0
        ]);
    }

    public function get_cost_amount(Request $request)
    {
        $this->authorize('read transaction');

        $cost_detail = CostDetail::find($request->cost_detail_id);

        return response()->json([
            'amount' => number_format($cost_detail->amount),
        ]);
    }

    public function get_account_number(Request $request)
    {
        $this->authorize('read transaction');

        $payment_method = PaymentMethod::find($request->payment_method_id);

        if ($payment_method) {
            return response()->json([
                'account_number' => $payment_method->account_number ?? '-',
            ]);
        } else {
            return response()->json([
                'account_number' => '',
            ]);
        }
    }

    public function print(Transaction $transaction)
    {
        $this->authorize('print transaction');

        return view('manage.finance.transaction.print', [
            'transaction' => $transaction
        ]);
    }
}
