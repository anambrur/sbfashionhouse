<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $fillable = [
		"id",
		"commentable_id",
		"commentable_type",
		"p_c_id",
		"comments",
		"created_by",
		"modified_by",
		"status"
	];
	public function blog() {
//		return
	}
	public function user() {
		return $this->belongsTo( "App\User", "created_by" );
	}

	public function commentable() {
		return $this->morphTo();
	}
}
