<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    protected $fillable = [
//        "id",
//        "title",
//        "short_description",
//        "long_description",
//        "image",
//        "slug",
//        "sku",
//        "stock_status",
//        "is_special",
//        "tax_class",
//        "regular_price",
//        "sale_price",
//        "brand_id",
//        "is_sticky",
//        "comment_enable",
//        "comments",
//        "views",
//        "seo_title",
//        "meta_key",
//        "meta_description",
//        "created_by",
//        "modified_by",
//        "status"
//    ];
    protected $table = "products";

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function categories()
    {
        return $this->morphToMany("App\Model\Common\Category", "categoryable");
    }

    public function tags()
    {
        return $this->morphToMany("App\Model\Common\Tag", "taggable");
    }
//    public function attributes()
//    {
//        return $this->morphToMany("App\Model\Common\Attribute", "attributables");
//    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withTimestamps();
    }

    public function attributeProduct()
    {
        return $this->hasMany(AttributeProduct::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo("App\User", "created_by");
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getStarRating()
    {
        $count = $this->reviews()->count();
        if (empty($count)) {
            return 0;
        }
        $starCountSum = $this->reviews()->sum('rating');
        $average = $starCountSum / $count;
        return $average;
    }
}
