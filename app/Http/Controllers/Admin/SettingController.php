<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use App\Models\GeneralSetting as Setting;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $data['gs'] = Setting::first();
        $data['pageTitle'] = 'Application Settings';
        $data['pageSubTitle'] = 'Settings';

        return view('admin.general.index', $data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            "name" => "required|max:50",
            "email" => "required|email|max:255",
            "currency" => "required|max:255",
            "logo" => "nullable|image|mimes:jpg,jpeg,png",
            "favicon" => "nullable|image|mimes:png",
        ]);

        $setting = Setting::first();
        $setting->appname = $request->name;
        $setting->email = $request->email;
        $setting->currency = $request->currency;
        $setting->registration = $request->registration ? 1 : 0;
        $setting->ev = $request->ev ? 1 : 0;
        if ($request->hasFile('logo')) {
            $setting->logo = \uploadImage($request->logo, \path()['logo']['path'], path()['logo']['size'], $setting->logo);
        }
        if ($request->hasFile('favicon')) {
            $setting->favicon = \uploadImage($request->favicon, \path()['favicon']['path'], path()['favicon']['size'], $setting->favicon);
        }
        $setting->update();

        return back()->with('success', 'Settings Updated');
    }

    public function email()
    {
        $pageTitle = "Email Configuration";
        $pageSubTitle = "Settings";

        return view('admin.general.email', \compact('pageTitle', 'pageSubTitle'));
    }

    public function emailConfigure(Request $request)
    {
        $request->validate([
            'email_method' => 'required|in:php,smtp',
            'host' => 'required_if:email_method,smtp',
            'port' => 'required_if:email_method,smtp',
            'username' => 'required_if:email_method,smtp',
            'password' => 'required_if:email_method,smtp',
            'enc' => 'required_if:email_method,smtp'
        ], [
            'host.required_if' => ':attribute is required for SMTP configuration',
            'port.required_if' => ':attribute is required for SMTP configuration',
            'username.required_if' => ':attribute is required for SMTP configuration',
            'password.required_if' => ':attribute is required for SMTP configuration',
            'enc.required_if' => ':attribute is required for SMTP configuration'
        ]);

        if ($request->email_method == 'php') {
            $data['method'] = 'php';
        } else {
            $request->merge(['method' => 'smtp']);
            $data = $request->only('method', 'host', 'port', 'enc', 'username', 'password', 'driver');
        }

        $general = GeneralSetting::first();
        $general->email_config = $data;
        $general->update();

        return back()->with('success', 'Mail Configuration Updated');
    }


    public function emailTemplate(Request $request)
    {
        $setting = GeneralSetting::first();
        $setting->email_template = $request->templates;
        $setting->update();

        return \back()->with('success', 'Templates updated successfully');
    }

    public function emailLog()
    {
        $logs = EmailLog::orderBy('id', 'desc')->paginate(10);
        $pageTitle = "Email Logs";
        $pageSubTitle = "Email";

        return view('admin.email.log', \compact('logs', 'pageTitle', 'pageSubTitle'));
    }

    public function emailShow($id)
    {
        $log = EmailLog::with('user')->findOrFail($id);
        $pageTitle = "Email Details Of - " . $log->user->username;
        $pageSubTitle = "Email";

        return view('admin.email.show', \compact('log', 'pageTitle', 'pageSubTitle'));
    }
}
