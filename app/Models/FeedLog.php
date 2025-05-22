<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedLog extends Model
{
    protected $fillable = [
        'vendor_id',
        'offers_total',
        'offers_matched',
        'offers_unmatched',
        'offers_skipped',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
