<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	public function method() {
		return $this->hasOne( 'App\Model\Common\Payment_method', 'id', 'payment_method_id');
	}
}
