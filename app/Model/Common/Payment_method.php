<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
