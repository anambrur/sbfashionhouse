<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Media_permissions extends Model {
	public $timestamps = false;

	public function media() {
		$this->hasOne( 'App\Model\Common\Media' );
	}

}
