<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Attributetitle extends Model
{
    protected $fillable = [
        "id",
        "title",
        "description",
        "image",
        "slug",
        "seo_title",
        "meta_key",
        "meta_description",
        "created_by",
        "modified_by",
        "status"
    ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
}
