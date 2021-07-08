<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function like(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);

        $video = Video::with('likes')->where('user_id','!=',Auth::id())->where('id',$request->id)->first();
        return $video;
    }
    public function dislike(){}
    public function comment(){}
    public function subscribe(){}
}
