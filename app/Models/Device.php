<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Device extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value, 'UTC')->format('Y-m-d H:i:s');
    }    
}
