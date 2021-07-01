<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $language = Language::where('code', $request->lang)->first();
        if (!$language) {
            $lang = 'EN';
        } else {
            $lang = $request->lang;
        }
        session()->put('lang', $lang);
        return redirect()->back();
    }
}
