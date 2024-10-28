<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{

    public function product()
    {
        return $this->belongsTo(Product::class);
//        return $this->hasOne( 'App\Model\Common\Product', 'id', 'product_id');
    }
}
