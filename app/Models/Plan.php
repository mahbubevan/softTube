<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    const WEEKLY = 2;
    const DAILY = 3;
    const MONTHLY = 0;
    const YEARLY = 1;

    const MB = 0;
    const GB = 1;
    const TB = 2;

    const LIFETIME = 0;
    const RECURRING = 1;

    const LOCAL = 0;
    const AWS = 1;

    const DEACTIVE = 0;
    const ACTIVE = 1;
}
