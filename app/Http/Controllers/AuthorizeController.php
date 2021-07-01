<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizeController extends Controller
{
    public function authorizForm()
    {
        return view('user.authorize.email');
    }

    public function resendCode()
    {
        
    }
}
