<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    protected $fillable = [
        "id",
        "attribute_id",
        "color_id",
        "product_id",
        "attribute_image",
        "attribute_qty",
        "attribute_price",
    ];
    protected $table = 'attribute_product';

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
