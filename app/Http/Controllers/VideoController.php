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

        $video = Video::where('user_id','!=',Auth::id())->where('id',$request->id)->firstOrFail();
        
    }
    public function dislike(){}
    public function comment(){}
    public function subscribe(){}
}
