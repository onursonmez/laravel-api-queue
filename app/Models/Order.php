<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    function device(){
        return $this->hasOne(\App\Models\Device::class, 'id', 'device_id');
    }
}