<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function list()
    {
        $pageTitle = "Plan Lists";
        $pageSubTitle = "Plans";
        $plans = Plan::orderBy('id','desc')->get();

        return view('admin.plan.index',compact('pageTitle','pageSubTitle','plans'));
    }

    public function create()
    {
        $pageTitle = "Create A Plan";
        $pageSubTitle = "Plans";

        return view('admin.plan.create',compact('pageTitle','pageSubTitle'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:32',
            'price' => 'required|numeric',
            'storage' => 'required|numeric',
            'storage_unit' => 'required|between:0,2',
            'storage_type' => 'required|in:0,1',
            'type' => 'required|in:0,1',
            'renewal_type' => 'required_if:type,=,1',
            'withdrawal_type' => 'required|between:0,3'
        ]);

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->storage = $request->storage;
        $plan->storage_unit = $request->storage_unit;
        $plan->storage_type = $request->storage_type;
        $plan->type = $request->type;

        if ($request->renewal_type) {
            $plan->renewal_type = $request->renewal_type;
        }
        $plan->withdrawal_type = $request->withdrawal_type;

        $plan->save();

        return back()->with('success','Plan Created Successfully');
    }

    public function edit(Plan $plan)
    {
        $pageTitle = "Edit Plan - ". $plan->name;
        $pageSubTitle = "Plans";

        return view('admin.plan.edit',compact('pageTitle','pageSubTitle','plan'));
    }
}
