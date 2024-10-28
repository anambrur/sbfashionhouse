<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        "id",
        "title",
        "slug",
        "actual_name",
        "created_by",
        "modified_by",
        "status"
    ];
    protected $table = 'units';
}
