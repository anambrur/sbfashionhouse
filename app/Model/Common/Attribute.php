<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        "id",
        "attributetitle_id",
        "title",
        "type",
        "status"
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 2);
    }

    public function scopeColor($query)
    {
        return $query->where('type', 'Color');
    }

    public function scopeSize($query)
    {
        return $query->where('type', 'Size');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
