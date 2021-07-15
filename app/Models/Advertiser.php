<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'advertiser_info' => 'object'
    ];

    const BANNER = 0;
    const SCRIPT = 1;
    const VIDEO = 2;
}
