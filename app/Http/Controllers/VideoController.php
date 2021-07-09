<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function like(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $video = Video::where('user_id', '!=', Auth::id())->where('id', $request->id)->with('likes')->first();
        $user = User::where('id', Auth::id())->first();
        $flag = 0;

        if (!$video->isLikedByUser()) {
            $user->likedVideos()->attach($video);
        } else {
            $user->likedVideos()->detach($video);
        }

        if ($video->isDislikedByUser()) {
            $user->dislikedVideos()->detach($video);
            $flag = 1;
        }
        $video = Video::where('user_id', '!=', Auth::id())->where('id', $request->id)->withCount('likes', 'dislikes')->first();
        $likeCount = $video->likes_count;
        $dislikeCount = $video->dislikes_count;

        return response()->json([
            'status' => $video->isLikedByUser(),
            'flag' => $flag,
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount
        ], 200);
    }
    public function dislike(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $video = Video::where('user_id', '!=', Auth::id())->where('id', $request->id)->with('likes')->first();
        $user = User::where('id', Auth::id())->first();
        $flag = 0;

        if (!$video->isDislikedByUser()) {
            $user->dislikedVideos()->attach($video);
        } else {
            $user->dislikedVideos()->detach($video);
        }

        if ($video->isLikedByUser()) {
            $user->likedVideos()->detach($video);
            $flag = 1;
        }
        $video = Video::where('user_id', '!=', Auth::id())->where('id', $request->id)->withCount('likes', 'dislikes')->first();
        $likeCount = $video->likes_count;
        $dislikeCount = $video->dislikes_count;

        return response()->json([
            'status' => $video->isDislikedByUser(),
            'flag' => $flag,
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount
        ], 200);
    }
    public function comment()
    {
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $video = Video::where('user_id', '!=', Auth::id())->where('id', $request->id)->with('user')->first();

        $user = User::where('id', Auth::id())->first();

        if (!$video->user->isSubscribedBy()) {
            $video->user->subscribedBy()->attach($user);
        } else {
            $video->user->subscribedBy()->detach($user);
        }

        return response()->json([
            'status' => $video->user->isSubscribedBy(),
            'subscribeCount' => $video->user->subscribedBy()->count(),
        ], 200);
    }
}
