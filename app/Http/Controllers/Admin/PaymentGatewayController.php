<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PaymentGatewayController extends Controller
{
    public function list()
    {
        $pageTitle = "Payment Gateways";
        $pageSubTitle = "Gateways";
        $items = PaymentCredential::orderBy('id', 'desc')->paginate();

        return view('admin.payment.gateway.list', \compact('pageTitle', 'pageSubTitle', 'items'));
    }

    public function edit($id)
    {
        $item = PaymentCredential::where('id', $id)->first();
        
        if (!$item) return back()->with('error', 'Invalid Gateway');
        
        $pageTitle = "Edit Payment Gateways - ".$item->method_name;
        $pageSubTitle = "Gateways";

        return view('admin.payment.gateway.edit', \compact('pageTitle', 'pageSubTitle', 'item'));
    }

    public function update(Request $request, $id)
    {
        $item = PaymentCredential::where('id', $id)->first();
        if (!$item) return back()->with('error', 'Invalid Gateway');

        $this->validate($request, [
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png']
        ]);

        foreach ($request->key as  $key => $value) {
            $data[$value] = $request->credentials[$key];
        }

        if ($item->method_name == "STRIPE") {
            $cred_path = config_path('stripecred.json');
            File::put($cred_path,json_encode($data));
        }

        $item->credentials = $data;
        if ($request->hasFile('image')) {
            try {
                $old = $item->image ?: null;
                $item->image = uploadImage($request->image, path()['gateway']['path'], path()['gateway']['size'], $old);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $item->update();
        return back()->with('success', 'Updated Successfully');
    }

    public function active($id)
    {
        $item = PaymentCredential::where('id', $id)->first();
        if (!$item) return back()->with('error', 'Invalid Gateway');

        $item->status = 1;
        $item->update();

        return back()->with('success', 'Successfully Activated');
    }

    public function deactive($id)
    {
        $item = PaymentCredential::where('id', $id)->first();
        if (!$item) return back()->with('error', 'Invalid Gateway');

        $item->status = 0;
        $item->update();

        return back()->with('success', 'Successfully Deactivated');
    }
}
