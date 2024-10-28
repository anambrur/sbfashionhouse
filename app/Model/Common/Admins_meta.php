<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Admins_meta extends Model
{
	protected $fillable = [
		'admin_id', 'meta_key', 'meta_value'
	];
}
