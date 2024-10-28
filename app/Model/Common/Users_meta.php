<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Users_meta extends Model
{
	protected $fillable = [
		'user_id', 'meta_key', 'meta_value'
	];
}
