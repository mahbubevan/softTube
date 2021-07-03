<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
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
        $user = User::where('id', Auth::id())->first();
        $userPlan = Plan::where('stripe_price', $user->subscriptions[0]->stripe_price)->first();

        // Checking File Format
        $getExt =  explode("/", $request->type)[1];
        $exts = array("flv", "mp4", "mkv", "ts", "mov", "avi", "wmv", "m3u8", "x-matroska", 'quicktime');

        // if (!array_search($getExt, $exts)) {
        //     return \response()->json([
        //         'error' => 'Only Supported Files Are: FLV, MP4, MKV, TS, MOV, AVI, WMV, M3U8'
        //     ], 400);
        // }

        // Checking File Size
        if ($userPlan->storage_unit == Plan::MB) {
            $sizeInMb = $this->formatBytes($request->size, "MB");
            if ($sizeInMb > $userPlan->storage) {
                return \response()->json([
                    'error' => "Your total upload max size - " . \number_format($userPlan->storage) . "MB"
                ], 400);
            }
        } elseif ($userPlan->storage_unit == Plan::GB) {
            $sizeInMb = $this->formatBytes($request->size, "GB");
            if ($sizeInMb > $userPlan->storage) {
                return \response()->json([
                    'error' => "Your total upload max size - " . \number_format($userPlan->storage) . "GB"
                ], 400);
            }
        } elseif ($userPlan->storage_unit == Plan::TB) {
            $sizeInMb = $this->formatBytes($request->size, "TB");
            if ($sizeInMb > $userPlan->storage) {
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

        if (!file_exists($tempLocation)) {
            makeDirectory($tempLocation);
        }

        $ext = explode("/", $request->type)[1];
        if ($ext == "x-matroska") {
            $ext = "mkv";
        }
        $tempPath = $tempLocation . "/temp.txt";

        file_put_contents($tempPath, $request->videos, FILE_APPEND);

        // $in = \fopen($tempPath, "a");
        // \fwrite($in, $request->videos);
        // \fclose($in);
        // \file_put_contents($tempPath, $request->videos, FILE_APPEND);


        return $request->all();
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
}
