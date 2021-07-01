<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Payment;
use App\Models\PaymentCredential;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $methods = PaymentCredential::where('status',1)->orderBy("id","desc")->get();
        
        $user = User::where('id',auth()->user()->id)->first();
        $paymentMethods = $user->paymentMethods();
        
        return view('home',compact('methods'));
    }

    public function selector()
    {
        $method = PaymentCredential::first();
        if(!$method) return back()->with('error','Invalid Method');

        if($method->method_name != "STRIPE")
        {
            return 0;
        }

        $user = User::where('id',auth()->user()->id)->first();
        $user->createOrGetStripeCustomer();
       
        return view('user.update-payment-method', [
            'intent' => $user->createSetupIntent(),
            'method' => $method
        ]);

    }

    public function savePaymentInfo(Request $request)
    {
        $this->validate($request,[
            'paymentMethod' => 'required'
        ]);
        
        $user = User::where('id',auth()->user()->id)->first();
        $user->addPaymentMethod($request->paymentMethod);
        $user->update();

        return response()->json([
            'url'=> route('user.index'),
            'status'=>1
        ],201);
    }

    public function setDepositAmount()
    {
        $method = PaymentCredential::where('method_name',"STRIPE")->first();

        if(!$method) return back()->with('error','Invalid Method');
        $user = User::where('id',auth()->user()->id)->first();
        $user->createOrGetStripeCustomer();
       
        return view('user.payment-process', [
            'intent' => $user->createSetupIntent(),
            'method' => $method
        ]);
    }

    public function depositMoney(Request $request)
    {
        $this->validate($request,[
            'amount' => 'required',
            'paymentMethod' => 'required'
        ]);

        $setting = GeneralSetting::first();
        $user = User::where('id',auth()->id())->first();

        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->method_id = 1;
        $payment->method_name = "STRIPE";
        $payment->amount = $request->amount;
        $payment->currency = $setting->currency;
        
        try {
            $res = $user->charge($request->amount*100,$request->paymentMethod);
            $payment->pm_type = $res->payment_method_types[0];
            $payment->reciept_url = $res->charges->data[0]->receipt_url;
            $payment->trx = $res->charges->data[0]->balance_transaction;
            $payment->status = 1;

            $user->balance += $request->amount;
            $user->update();

            $trx = new Transaction();
            $trx->user_id = $user->id;
            $trx->amount = $request->amount;
            $trx->charge = 0;
            $trx->post_balance = $user->balance;
            $trx->trx_type = Transaction::CREDIT;
            $trx->trx = $res->charges->data[0]->balance_transaction;
            $trx->details = "Deposti Via STRIPE";
            $trx->save();
            

        } catch (\Throwable $th) {
            $payment->status = 0;
        }

        $payment->save();

        return response()->json([
            'url'=> route('user.deposit.history'),
            'status'=>1
        ],201);
    }

    public function history()
    {
        $payments = Transaction::where('user_id',auth()->id())->get();
        
        return view('user.payment-history',compact('payments'));
    }
}
