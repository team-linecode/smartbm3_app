<?php

namespace App\Http\Controllers\Manage;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index($type, Request $request)
    {
        $this->authorize('read transaction report');

        if ($request->get('date') && $request->get('status')) {
            if (str_contains($request->get('date'), 'to')) {
                $explode_date = explode(' to ', $request->get('date'));

                $date_1 = date('Y-m-d', strtotime($explode_date[0])) . " 00:00:00";
                $date_2 = date('Y-m-d', strtotime($explode_date[1])) . " 23:59:59";

                $time = request()->get('time') == 'Latest' ? 'desc' : 'asc';

                $transactions = Transaction::whereBetween('date', [$date_1, $date_2])
                    ->where('status', $request->status == 'all' ? '!=' : '=', $request->status == 'all' ? 'all' : $request->status)
                    ->orderBy('created_at', $time)
                    ->get();
            } else {
                $date = date('Y-m-d', strtotime($request->get('date')));
                $transactions = Transaction::whereDate('date', $date)->get();
            }
        } else {
            $transactions = Transaction::latest()->get();
        }

        switch ($type) {
            case 'transaction':
                return view('manage.finance.report.transaction', [
                    'transactions' => $transactions
                ]);
                break;

            default:
                return view('manage.finance.report.transaction', [
                    'transactions' => $transactions
                ]);
                break;
        }
    }
}
