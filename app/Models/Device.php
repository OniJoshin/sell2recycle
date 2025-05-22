<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['brand', 'model', 'storage'];

    public function offers() {
        return $this->hasMany(Offer::class);
    }
    
    public function category()
    {
        return $this->belongsTo(DeviceCategory::class, 'device_category_id');
    }

}
