<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $table = 'shipping_methods';

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
