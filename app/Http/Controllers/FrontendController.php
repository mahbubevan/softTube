<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Video;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function main()
    {
        $videos = Video::where('status',Video::ACTIVE)->take(10)->get()->groupBy('category.name');
        
        return view('frontend.main',compact('videos'));
    }

    public function watch(Request $request)
    {
        dd($request->all());
    }

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
