<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function plan()
    {
        $plans = Plan::where('status',Plan::ACTIVE)->get();

        return view('user.purchase.plan',compact('plans'));
    }

    public function purchase(Plan $plan)
    {
        $user = User::where('id',Auth::id())->firstOrFail();
        if ($user->hasDefaultPaymentMethod()) {
            $user->newSubscription('Basic','price_1J8m2CIlOpxxiipgHupOYltn')->add();
            
            return redirect()->route('user.index');
        }

        return redirect()->route('user.deposit.selector');
    }
}
