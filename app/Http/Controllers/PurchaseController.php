<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function plan()
    {
        $plans = Plan::where('status',Plan::ACTIVE)->get();

        return view('user.purchase.plan',compact('plans'));
    }
}
