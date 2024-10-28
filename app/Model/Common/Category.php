<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        "id",
        "parent_id",
        "title",
        "color_code",
        "priority",
        "description",
        "image",
        "fav_icon",
        "slug",
        "views",
        "total_posts",
        "seo_title",
        "meta_key",
        "meta_description",
        "created_by",
        "modified_by",
        "status"
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function blogs()
    {
        return $this->morphedByMany('App\Model\Common\Blog', 'categoryable');
    }

    public function products()
    {
        return $this->morphedByMany('App\Model\Common\Product', 'categoryable');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Model\Common\Category', 'parent_id')->with('subcategories');
    }
}
