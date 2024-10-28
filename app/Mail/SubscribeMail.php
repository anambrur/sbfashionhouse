<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeMail extends Mailable {
	use Queueable, SerializesModels;

	public $info;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct( $info ) {
		$this->info = $info;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$subject = "Doodle Digital Newsletter Subscription";

		return $this->subject( $subject )->view( 'email.subscribe' );
	}
}
