<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
