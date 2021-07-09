<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function main()
    {
        if (Auth::user()) {
            $videos = Video::where('user_id', '!=', Auth::id())->where('status', Video::ACTIVE)->take(10)->get()->groupBy('category.name');
        } else {
            $videos = Video::where('status', Video::ACTIVE)->take(10)->get()->groupBy('category.name');
        }

        return view('frontend.main', compact('videos'));
    }

    public function watch(Request $request)
    {
        $video = Video::where('id', $request->v)->where('status', Video::ACTIVE)->withCount('likes', 'dislikes','comments')->with('user','comments.user')->first();

        return view('frontend.watch', compact('video'));
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
