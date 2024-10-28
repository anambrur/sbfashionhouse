<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model {
	public function categories() {
		return $this->morphToMany( "App\Model\Common\Category", "categoryable" );
	}

	public function tags() {
		return $this->morphToMany( "App\Model\Common\Tag", "taggable" );
	}

	public function user() {
		return $this->belongsTo( "App\User", "created_by" );
	}

	public function comments() {
		return $this->morphMany( Comment::class, 'commentable' );
	}
}
