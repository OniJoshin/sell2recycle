<?php

namespace App\Models;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vendor extends Model
{
    use HasFactory;
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

}
