<?php

namespace App\Mail;

use App\SM\SM;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Offer extends Mailable {
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
		$subject = title_case( $this->info->discount_title . ' - ' . SM::sm_get_site_name() );

		return $this->subject( $subject )
		            ->view( 'email.offer' );
	}
}
