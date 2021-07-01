<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transaction_list()
    {
        $logs = Transaction::orderBy('id','desc')->paginate();
        $pageTitle  = "Transaction Lists";
        $pageSubTitle = "Transactions";

        return view('admin.transaction.list',compact('logs','pageTitle','pageSubTitle'));
    }

    public function payment_list()
    {
        $logs = Payment::orderBy('id','desc')->paginate();
        $pageTitle  = "All Payments";
        $pageSubTitle = "Payment";

        return view('admin.payment.list',compact('logs','pageTitle','pageSubTitle'));
    }
}
