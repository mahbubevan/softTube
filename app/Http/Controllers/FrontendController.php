<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoView;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function main()
    {
        if (Auth::user()) {
            $videos = Video::where('user_id', '!=', Auth::id())->where('status', Video::ACTIVE)->withCount('views')->take(10)->get()->groupBy('category.name');
        } else {
            $videos = Video::where('status', Video::ACTIVE)->withCount('views')->take(10)->get()->groupBy('category.name');
        }

        return view('frontend.main', compact('videos'));
    }

    public function watch(Request $request)
    {
        $video = Video::where('id', $request->v)->where('status', Video::ACTIVE)->withCount('likes', 'dislikes', 'comments', 'views')->with('user', 'comments.user')->first();

        if (!Auth::user()) {
            $userIp = request()->ip();
            $videoView = VideoView::where('ip', $userIp)->where('video_id', $video->id)->first();
        } else {
            $videoView = VideoView::where('user_id', Auth::id())->where('video_id', $video->id)->first();
            $userIp = null;
        }

        $viewCounted = 0;

        if (!$videoView) {
            $viewCounted = 1;
        }

        return view('frontend.watch', compact('video', 'userIp', 'viewCounted', 'videoView'));
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

    //video views count
    public function videoViewCount(Request $request)
    {
        $this->validate($request, [
            'videoId' => 'required'
        ]);

        $video = Video::where('id', $request->videoId)->where('status', Video::ACTIVE)->first();

        $userIp = request()->ip();
        if (!Auth::user()) {
            $videoView = VideoView::where('ip', $userIp)->where('video_id', $video->id)->first();
        } else {
            $videoView = VideoView::where('user_id', Auth::id())->where('video_id', $video->id)->first();
        }

        if ($videoView) {
            $videoView->duration = $request->duration;
            $videoView->update();

            return response()->json([
                "message" => "View Counted",
                "status" => 2
            ], 200);
        }

        $videoView = new VideoView();
        $videoView->video_id = $video->id;
        $videoView->user_id = Auth::id();
        $videoView->ip = $userIp;
        $videoView->duration = $request->duration;
        $videoView->save();

        $video = Video::where('id', $request->videoId)->where('status', Video::ACTIVE)->withCount('views')->first();

        $data = [
            "viewId" => $videoView->id,
            "count" => $video->views_count,
            "status" => 1
        ];

        return response()->json($data, 200);
    }
}
