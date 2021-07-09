<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function upload()
    {
        return view('user.video.upload');
    }

    public function checkExtSize(Request $request)
    {
        $user = User::with('videos')->withSum('videos', 'size')->where('id', Auth::id())->first();
        $userPlan = Plan::where('stripe_price', $user->subscriptions[0]->stripe_price)->first();
        // Checking File Format
        try {
            $getExt =  explode("/", $request->type)[1];
        } catch (\Throwable $th) {
            $getExt = explode(".", $request->name)[1];
        }
        $exts = array("flv", "mp4", "mkv", "ts", "mov", "avi", "wmv", "m3u8", "x-matroska", 'quicktime');

        if (!array_search($getExt, $exts)) {
            return \response()->json([
                'error' => 'Only Supported Files Are: FLV, MP4, MKV, TS, MOV, AVI, WMV, M3U8'
            ], 400);
        }

        // Checking File Size
        // also have to check user used storage. it will be implemented after video info save to db.

        if ($userPlan->storage_unit == Plan::MB) {
            $sizeInMb = $this->formatBytes($request->size, "MB");
            $userUsedMb = $this->formatBytes($user->videos_sum_size, "MB");
            $totalUsedMb = $sizeInMb + $userUsedMb;
            if ($totalUsedMb > $userPlan->storage) {
                return \response()->json([
                    'error' => "Your total upload max size - " . \number_format($userPlan->storage) . "MB"
                ], 400);
            }
        } elseif ($userPlan->storage_unit == Plan::GB) {
            $sizeInMb = $this->formatBytes($request->size, "GB");
            $userUsedMb = $this->formatBytes($user->videos_sum_size, "GB");
            $totalUsedMb = $sizeInMb + $userUsedMb;
            if ($totalUsedMb > $userPlan->storage) {
                return \response()->json([
                    'error' => "Your total upload max size - " . \number_format($userPlan->storage) . "GB"
                ], 400);
            }
        } elseif ($userPlan->storage_unit == Plan::TB) {
            $sizeInMb = $this->formatBytes($request->size, "TB");
            $userUsedMb = $this->formatBytes($user->videos_sum_size, "TB");
            $totalUsedMb = $sizeInMb + $userUsedMb;
            if ($totalUsedMb > $userPlan->storage) {
                return \response()->json([
                    'error' => "Your total upload max size - " . \number_format($userPlan->storage) . "TB"
                ], 400);
            }
        } else {
        }
    }

    public function store(Request $request)
    {
        $tempLocation = \path(Auth::user()->username)['video']['tempPath'];
        $mainLocation = \path(Auth::user()->username)['video']['mainPath'];

        if (!file_exists($mainLocation)) {
            makeDirectory($mainLocation);
        }

        $ext = $request->video->getClientOriginalExtension();
        $name = \trim(explode(".", $request->video->getClientOriginalName())[0]);

        // Check user plan storage and upload to AMAZON S3

        $user = User::where('id', Auth::id())->first();
        $userPlan = Plan::where('stripe_price', $user->subscriptions[0]->stripe_price)->first();

        if ($userPlan->storage_type == Plan::AWS) {
            $path = "From AMAZON";
            $flag = $request->file('video')->store(auth()->user()->username, 's3'); // Not Tested Yet
        } else {
            $path = $mainLocation . "/" . Carbon::now()->format('Y-m-dHis') . "$name.$ext";

            try {
                chmod($mainLocation, 0770);
            } catch (\Throwable $th) {
                return $th;
            }
            try {
                $flag = move_uploaded_file($request->video, $path);
            } catch (\Throwable $th) {
                return $th;
            }
        }

        if ($flag) {
            $video = new Video();
            $video->user_id = Auth::id();
            $video->path = $path;

            if ($userPlan->storage_type == Plan::AWS) {
                $video->storage = Plan::AWS;
            } else {
                $video->storage = Plan::LOCAL;
            }

            $video->size = $request->size;
            // Here Status will be updated depended on admin video review on or off.
            $video->save();

            $data = [
                "status" => 0,
                "video" => $video->id,
                "message" => "File Uploaded Successfully"
            ];
            return \response()->json($data, 200);
        }

        $data = ["status" => 1, "message" => "File Couldn't Uploaded"];
        return \response()->json($data, 500);
    }

    public function videoDetailsEdit(Request $request)
    {
        $video = Video::where('user_id', Auth::id())->where('id', $request->videoId)->first();
        if (!$video) return redirect()->route('user.upload')->with('error', 'Invalid Video Request');

        $categories = Category::get();
        $user = User::where('id', Auth::id())->first();
        $userPlan = Plan::where('stripe_price', $user->subscriptions[0]->stripe_price)->first();

        return view('user.video.edit', compact('video', 'categories', 'userPlan'));
    }

    public function videoDetailsUpdate(Request $request)
    {
        $video = Video::where('user_id', Auth::id())->where('id', $request->videoId)->first();
        if (!$video) return redirect()->route('user.upload')->with('error', 'Invalid Video Request');
        $location = \path()['video']['thumbnail'];

        if ($request->has('thumbnail')) {
            $video->thumbnail = \uploadImage($request->thumbnail, $location, "300x300", $video->thumbnail);
        }
        $video->title = $request->title;
        $video->category_id = $request->category;
        $video->tags = $request->tags;
        $video->description = $request->description;
        $video->update();

        return \redirect()->route('user.index')->with('success', 'Video Information Updated');
    }

    protected function formatBytes($bytes, $unit)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $index = array_search($unit, $units);

        for ($i = 0; $i < $index; $i++) {
            $bytes /= 1024;
        }

        return $bytes;
    }

    public function videos()
    {
        $videos = Video::where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(20);

        return view('user.video.list', compact('videos'));
    }
}
