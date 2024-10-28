<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/22/17
 * Time: 10:28 AM
 */

namespace App\Http\Controllers\Debug;

use App\Model\Common\Media;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\Checkout;
use Illuminate\Support\Facades\Storage;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;


use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;


use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;
use App\Mail\InvoiceMail;
use App\SM\SM;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Http\Request;

class Debug extends Controller {
	public function maintenance() {
		$is_maintenance_enable = SM::get_setting_value( 'is_maintenance_enable' );
		if ( $is_maintenance_enable != 1 ) {
			return redirect( '/' );
		}
		$when_site_will_live = SM::get_setting_value( 'when_site_will_live' );

		$data['minutes'] = ceil( floor( strtotime( $when_site_will_live ) - time() ) / ( 60 ) );
		$data['minutes'] = ( $data['minutes'] < 0 ) ? 0 : $data['minutes'];

		return view( "page.maintenance", $data );
	}

	public function plan() {
//		echo '2017-12-18T9:45:04Z';
//		echo '<br>'.gmdate("Y-m-d\TH:i:s\Z", strtotime('+1 Day'));
//		exit;
		$plan = new Plan();
		$plan->setName( 'T-Shirt of the Month Club Plan' )
		     ->setDescription( 'Template creation.' )
		     ->setType( 'fixed' );

		$paymentDefinition = new PaymentDefinition();

		$paymentDefinition->setName( 'Regular Payments' )
		                  ->setType( 'REGULAR' )
		                  ->setFrequency( 'Month' )
		                  ->setFrequencyInterval( "1" )
		                  ->setCycles( "12" )
		                  ->setAmount( new Currency( array( 'value' => 100, 'currency' => 'USD' ) ) );

		$chargeModel = new ChargeModel();
		$chargeModel->setType( 'SHIPPING' )
		            ->setAmount( new Currency( array( 'value' => 10, 'currency' => 'USD' ) ) );

		$paymentDefinition->setChargeModels( array( $chargeModel ) );

		$merchantPreferences = new MerchantPreferences();


		$merchantPreferences->setReturnUrl( url( "plan-success?success=true" ) )
		                    ->setCancelUrl( url( "plan-success?success=false" ) )
		                    ->setAutoBillAmount( "yes" )
		                    ->setInitialFailAmountAction( "CONTINUE" )
		                    ->setMaxFailAttempts( "0" )
		                    ->setSetupFee( new Currency( array( 'value' => 1200, 'currency' => 'USD' ) ) );


		$plan->setPaymentDefinitions( array( $paymentDefinition ) );
		$plan->setMerchantPreferences( $merchantPreferences );

		$request    = clone $plan;
		$co         = new Checkout();
		$apiContext = $co->paypalInit( 1 );

		try {
			$output = $plan->create( $apiContext );
		} catch ( Exception $ex ) {
			echo "<pre>";
			print_r( $ex->getCode() );
			print_r( $ex->getData() );
			echo "</pre>";
			exit();
		}

		try {
			$patch = new Patch();

			$value = new PayPalModel( '{
		       "state":"ACTIVE"
		     }' );

			$patch->setOp( 'replace' )
			      ->setPath( '/' )
			      ->setValue( $value );
			$patchRequest = new PatchRequest();
			$patchRequest->addPatch( $patch );

			$output->update( $patchRequest, $apiContext );

			$plan = Plan::get( $output->getId(), $apiContext );
		} catch ( Exception $ex ) {
			echo "<pre>";
			print_r( $ex->getData() );
			echo "</pre>";
			exit();
		}

		$agreement = new Agreement();

		$agreement->setName( 'Base Agreement' )
		          ->setDescription( 'Basic Agreement' )
		          ->setStartDate( gmdate( "Y-m-d\TH:i:s\Z", strtotime( '+1 Day' ) ) );
		$plan = new Plan();
		$plan->setId( $output->getId() );
		$agreement->setPlan( $plan );

		$payer = new Payer();
		$payer->setPaymentMethod( 'paypal' );
		$agreement->setPayer( $payer );

		try {
			$agreement   = $agreement->create( $apiContext );
			$approvalUrl = $agreement->getApprovalLink();
		} catch ( Exception $ex ) {
			echo "<pre>agreement<br>";
			print_r( $ex->getData() );
			echo "</pre>";
			exit();
		}

		echo '<a href="' . $approvalUrl . '" target="_blank">click me</a>';
		exit();

	}

	public function planSuccess() {
		if ( isset( $_GET['success'] ) && $_GET['success'] == 'true' ) {
			$token      = $_GET['token'];
			$agreement  = new \PayPal\Api\Agreement();
			$co         = new Checkout();
			$apiContext = $co->paypalInit( 1 );
			try {
				$agreement->execute( $token, $apiContext );
			} catch ( Exception $ex ) {
				echo "<pre>";
				print_r( $ex->getData() );
				echo "</pre>";
				exit();
			}
			try {
				$agreement = \PayPal\Api\Agreement::get( $agreement->getId(), $apiContext );
			} catch ( Exception $ex ) {
				echo "<pre>";
				print_r( $ex->getData() );
				echo "</pre>";
				exit();
			}
			echo "<pre>";
			print_r( $agreement );
			echo "</pre>";
			exit();
		} else {
			echo "<pre>";
			print_r( "cancelled" );
			echo "</pre>";
			exit();
		}

	}


	public function backlink() {
		$domain = "kvcodes.com"; //Enter your desired site to check back-links

		$url = "http://www.google.com/search?q=link%3A" . $domain;

		$file = file_get_contents( $url );

		if ( ! strstr( $file, 'did not match any documents' ) ) {
			$linksto = strstr( $file, "of about " );
			$linksto = substr( $linksto, strlen( "of about" ) );
			$linksto = str_replace( strstr( $linksto, '' ), '', $linksto );
			echo $linksto . ' backlinks';
		} else {
			echo 'No backlinks';
		}
		exit;
	}

	public function test() {
		$filesStr   = 'index.php,interview_question_by_mizan.pdf,interview_question_by_mizan.docx';
		$filesArray = explode( ',', $filesStr );
		$files      = Media::whereIn( 'slug', $filesArray )->get();
		echo "<pre>";
		print_r( $files );
		echo "</pre>";
		exit();
	}

	public function testMail( $type, $id, $emial = null ) {
		if ( $type == 'invoice' ) {
			$emial          = ( $emial == null ) ? 'abrasel600@gmail.com' : 'engr.mrksohag@gmail.com';
			$extra          = new \stdClass();
			$extra->message = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
			\Mail::to( $emial )->queue( new InvoiceMail( $id, $extra ) );
			echo "<pre>";
			print_r( "'mail send';" );
			echo "</pre>";
			exit();
		} else {
			echo "<pre>";
			print_r( "'mail send failed';" );
			echo "</pre>";
			exit();
		}
	}


	public function options() {
		return view( 'nptl-admin/debug/package_form' );
	}

	public function optionsRequest() {
		echo "<pre>";
		print_r( $_POST );
		echo "</pre>";
		exit();
	}

	public function regenerateAndOptimizeImage() {
		$medias = Media::where( 'is_private', 0 )->get();
		foreach ( $medias as $media ) {
			$path     = config( 'constant.smUploadsDir' );
			$filename = $filename1 = $media->slug;

			$explode = explode( '.', $filename );
			if ( count( $explode ) > 1 ) {
				$filename1 = $explode[0] . '_mrks.' . $explode[1];
			}


			$file_chk  = storage_path( "app/public/" . $path . $filename );
			$file_chk1 = storage_path( "app/public/" . $path . $filename1 );
			if (
				Storage::disk( 'public' )->exists( $path . $filename1 )
				&& @getimagesize( $file_chk1 )
			) {
				SM::smCloneImage( $filename1, $path . $filename );
				$all_width  = config( 'constant.smImgWidth' );
				$all_height = config( 'constant.smImgHeight' );
//				SM::sm_image_resize( $all_width, $all_height, storage_path( "app/public/" . $path ), $filename, false );
//				echo "filename1 $filename1 exist<br>";
//
//				SM::smImageOptimize( $file_chk );

				echo "filename $filename1 exist<br>";
			} else {
				echo $filename . " not exist<br>";
			}
		}
	}

	public function optimizeImage() {
		$file = 'uploads/1_1_45x30.jpg';

		$smImgWidth = config( 'constant.smImgWidth' );
		$widthStr   = '';
		$loop       = 0;
		foreach ( $smImgWidth as $width ) {
			if ( $loop > 0 ) {
				$widthStr .= '|';
			}
			$widthStr .= '_';
			$widthStr .= $width . 'x';
			$loop ++;
		}

//		if ( preg_match( '/' . $widthStr . '/', $file, $matches ) ) {
//			echo "<pre>";
//			print_r($matches);
//			echo "</pre>";
//			exit();
//		} else {
//			$explode  = explode( '.', $file );
//			$filename = $explode[0] . '_mrks.' . $explode[1];
//			echo "<pre>";
//			print_r($filename);
//			echo "</pre>";
//			exit();
//		}
		echo $widthStr;
//		print_r($files);
		echo "<pre>";
		exit();
		$files = \Storage::disk( 'public' )->files( config( 'constant.smUploadsDir' ) );
		foreach ( $files as $file ) {

			if ( preg_match( '/' . $widthStr . '/', $file, $matches ) ) {
				ImageOptimizer::optimize( storage_path( 'app/public/' . $file ) );
			} else {
				$explode = explode( '.', $file );
				if ( count( $explode ) > 1 ) {
					$filename = $explode[0] . '_mrks.' . $explode[1];
					if ( ! Storage::disk( 'public' )->has( $filename ) ) {
						Storage::disk( 'public' )->copy( $file, $filename );
					}
				}
				ImageOptimizer::optimize( storage_path( 'app/public/' . $file ) );
			}


//		print_r(storage_path('app/public/uploads/1.jpg'));
			print_r( $file . "<br>" );
		}
		echo "<br>completed<br></pre>";
		exit();
	}
}