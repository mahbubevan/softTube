<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class PurchaseController extends Controller
{
    public function plan()
    {
        $plans = Plan::where('status',Plan::ACTIVE)->get();
        $user = User::where('id',Auth::id())->first();
        $stripe_price = $user->subscriptions[0]->stripe_price;
        
        return view('user.purchase.plan',compact('plans','stripe_price'));
    }

    public function purchase(Plan $plan)
    {
        $user = User::where('id',Auth::id())->firstOrFail();

        if ($user->hasDefaultPaymentMethod()) {

            if($user->subscriptions->isNotEmpty())
            {
                $existingPlan = Plan::where('stripe_price',$user->subscriptions[0]->stripe_price)->first();
                $user->subscription($existingPlan->name)->swap($plan->stripe_price);
            
            return redirect()->route('user.index')->with('success','Successfully Subscribed');
            }

            $user->newSubscription($plan->name,$plan->stripe_price)->add();
            
            return redirect()->route('user.index')->with('success','Successfully Subscribed');
        }

        return redirect()->route('user.deposit.selector');
    }
}
