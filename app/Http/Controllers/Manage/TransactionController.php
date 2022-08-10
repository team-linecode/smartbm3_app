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
        $this->authorize('finance access');

        return view('manage.finance.transaction.index', [
            'users' => User::whereHas('role', function ($q) {
                $q->where('name', 'student');
            })->get(),
            'transactions' => Transaction::latest()->get()
        ]);
    }

    public function create()
    {
        $this->authorize('finance access');

        return view('manage.finance.transaction.create', [
            'users' => User::whereHas('role', function ($q) {
                $q->where('name', 'student');
            })->get(),
        ]);
    }

    public function save_transaction(Request $request)
    {
        $this->authorize('finance access');

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
        $this->authorize('finance access');

        $request->validate(
            [
                'transaction_date' => 'required|date',
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

    public function create_detail(Transaction $transaction)
    {
        $this->authorize('finance access');

        return view('manage.finance.transaction.create_detail', [
            'cost_spp' => Cost::where('schoolyear_id', $transaction->user->schoolyear_id)->whereHas('cost_category', function ($query) {
                $query->where('slug', 'spp');
            })->first(),
            'trans' => $transaction,
            'months' => Month::all(),
            'payment_methods' => PaymentMethod::where('status', 'active')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('finance access');

        $request->validate([
            'cost_id' => 'required',
            'amount' => 'required'
        ]);

        // membuat variabel yang dibutuhkan
        $cost = Cost::find($request->cost_id);
        $transaction = Transaction::findOrFail($request->transaction_id);

        // modify request data
        $request['amount'] = cleanCurrency($request->amount);
        $request['date'] = $request->date;
        $request['transaction_id'] = $request->transaction_id;
        // jika cost category sama dengan gedung maka isi sesuai gelombangnya
        if ($cost->cost_category->slug == 'gedung') {
            $request['cost_detail_id'] = $cost->get_detail_by_group($transaction->user->group_id)->id;
        } else if ($cost->cost_category->slug == 'lain-lain') {
            $request['cost_detail_id'] = $cost->details->first()->cost_id;
        }

        // check transaction detail
        $check_trx_detail = TransactionDetail::where('cost_detail_id', $request->cost_detail_id)
            ->where('transaction_id', $request->transaction_id)
            ->first();
        // jika detail transaksi ada dan pembayaran sama dengan 'spp'
        if ($check_trx_detail && $cost->cost_category->slug == 'spp') {
            // jika tanggalnya sama maka transaksi tidak dapat dibuat
            if (date('F Y', strtotime($request->date)) == date('F Y', strtotime($check_trx_detail->date))) {
                return back()->with('alert-error', 'Data transaksi sudah ada');
            }
        } else if ($check_trx_detail) {
            return back()->with('alert-error', 'Data transaksi sudah ada');
        }

        // update transaction total
        $transaction = Transaction::find($request->transaction_id);
        $transaction->total += $request->amount;
        $transaction->update();

        TransactionDetail::create($request->all());

        return back()->with('alert-success', 'Data transaksi berhasil disimpan');
    }

    public function detail_destroy(TransactionDetail $transaction_detail)
    {
        $this->authorize('finance access');

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
        $this->authorize('finance access');

        $user = User::where('id', $request->user_id)
            ->with('classroom')
            ->with('expertise')
            ->with('schoolyear')
            ->first();
        return response()->json($user);
    }

    public function get_cost_detail(Request $request)
    {
        $this->authorize('finance access');

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
        $this->authorize('finance access');

        $cost_detail = CostDetail::find($request->cost_detail_id);

        return response()->json([
            'amount' => number_format($cost_detail->amount),
        ]);
    }

    public function get_account_number(Request $request)
    {
        $this->authorize('finance access');

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
        $this->authorize('finance access');

        return view('manage.finance.transaction.print', [
            'transaction' => $transaction
        ]);
    }
}
