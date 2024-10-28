<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $fillable = [
        "id",
        "title",
        "description",
        "image",
        "slug",
        "website",
        "views",
        "total_posts",
        "seo_title",
        "meta_key",
        "meta_description",
        "created_by",
        "modified_by",
        "status"
    ];
    protected $table = 'brands';

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
//	public function blogs() {
//		return $this->morphedByMany( 'App\Model\Common\Blog', 'categoryable' );
//	}
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
