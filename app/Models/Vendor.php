<?php

namespace App\Models;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'feed_url',
        'api_key',
        'payment_info',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function feedLogs()
    {
        return $this->hasMany(\App\Models\FeedLog::class);
    }

}
