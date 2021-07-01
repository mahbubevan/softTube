<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pageTitle = "Dashboard";
        $pageSubTitle = "Dashboard";

        return view('admin.dashboard', compact('pageTitle', 'pageSubTitle'));
    }

    public function profile()
    {
        $pageTitle = 'Profile';
        $pageSubTitle = 'Profile';

        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin', 'pageSubTitle'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png']
        ]);

        $admin = Admin::where('id', auth()->guard('admin')->user()->id)->first();
        if ($request->hasFile('image')) {
            try {
                $old = $admin->image ?: null;
                $admin->image = uploadImage($request->image, path()['admin']['path'], path()['admin']['size'], $old);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return redirect()->route('admin.profile')->with("success", 'Your profile has been updated.');
    }
}
