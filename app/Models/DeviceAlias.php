<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAlias extends Model
{
    protected $fillable = ['device_id', 'alias'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}

