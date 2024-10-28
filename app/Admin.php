<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PasswordChangeNotification as ResetPasswordNotification;
class Admin extends Authenticable
{
    use Notifiable;

	protected $fillable = [
		'username', 'firstname', 'lastname', 'email', 'password', 'role', 'image', 'status'
	];
	protected $hidden = [
		'password', 'remember_token'
	];

	function blog()
	{
		return $this->hasMany('App/Model/Common/Blogs/Blog', 'id', 'created_by');
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));
	}

	public function role() {
		return $this->belongsTo( 'App\Model\Common\Role' );
	}
}
