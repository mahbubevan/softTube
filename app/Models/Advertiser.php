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
}
