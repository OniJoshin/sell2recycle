<?php

namespace App\Models;

use App\Models\Device;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vendor_id',
        'device_id',
        'vendor_product_id',
        'product_url',
        'category',
        'condition',
        'network',
        'price',
        'valid_until',
        'match_method',
    ];

    protected $casts = [
        'valid_until' => 'datetime',
    ];
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function device() {
        return $this->belongsTo(Device::class);
    }
}


