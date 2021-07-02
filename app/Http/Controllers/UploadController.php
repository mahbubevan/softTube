<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload()
    {
        return view('user.video.upload');
    }
}
