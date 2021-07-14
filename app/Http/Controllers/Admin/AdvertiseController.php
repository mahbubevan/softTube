<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    public function lists()
    {
        $pageTitle = "Advertise Lists";
        $pageSubTitle = "Advertise";
        $ads = Advertiser::orderBy('id','desc')->paginate(20);

        return view('admin.advertiser.list',compact('pageTitle','pageSubTitle','ads'));
    }

    public function create()
    {
        $pageTitle = "New Advertise Create";
        $pageSubTitle = "Advertise";

        return view('admin.advertiser.create',compact('pageTitle','pageSubTitle'));
    }
}
