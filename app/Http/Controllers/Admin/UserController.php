<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userList()
    {
        $pageTitle = "All Users List";
        $pageSubTitle = "Users";

        $users = User::orderBy('id', 'desc')->paginate();

        return view('admin.user.list', \compact('pageTitle', 'pageSubTitle', 'users'));
    }

    public function activeList()
    {
        $pageTitle = "Active Users List";
        $pageSubTitle = "Users";

        $users = User::where('status', 1)->orderBy('id', 'desc')->paginate();

        return view('admin.user.list', \compact('pageTitle', 'pageSubTitle', 'users'));
    }

    public function bannedList()
    {
        $pageTitle = "Banned Users List";
        $pageSubTitle = "Users";

        $users = User::where('status', 0)->orderBy('id', 'desc')->paginate();

        return view('admin.user.list', \compact('pageTitle', 'pageSubTitle', 'users'));
    }

    public function emailUnverifiedList()
    {
        $pageTitle = "Email Unverified Users List";
        $pageSubTitle = "Users";

        $users = User::where('status', 0)->orderBy('id', 'desc')->paginate();

        return view('admin.user.list', \compact('pageTitle', 'pageSubTitle', 'users'));
    }

    public function sendEmailAll()
    {
        $pageTitle = "Send Email To All";
        $pageSubTitle = "Email";
        return view('admin.user.email', \compact('pageTitle', 'pageSubTitle'));
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        $pageTitle = "User Details - " . $user->name;
        $pageSubTitle = "Users Detail";
        return view('admin.user.show', \compact('pageTitle', 'pageSubTitle', 'user'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required|string|max:65000',
        ]);

        $users = User::get();
        foreach ($users as $key => $value) {
            email($value, $request->subject, $request->message);
        }

        return back()->with('success', 'Email Send To All');
    }
}
