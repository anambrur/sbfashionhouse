<?php

namespace App\Http\Requests;

use App\Rules\SmYearHypenMonth;
use Illuminate\Foundation\Http\FormRequest;

class OrderValidation extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
            
		$rules["payment_method"] = "required|integer";
//		$rules["firstname"]      = "required";
//		$rules["lastname"]       = "required";
//		$rules["street"]         = "required";
//		$rules["city"]           = "required";
//		$rules["zip"]            = "required";
//		$rules["country"]        = "required";
//		$rules["state"]          = "required";
//		if ( \Auth::check() ) {
//			$rules["contact_email"] = "required|email";
//		} else {
//			$rules["contact_email"] = "required|email|unique:users,email";
//		}
//		$count_file = count( $this->file( 'attachments' ) );
//		$maxPost    = config( 'constant.smPostMaxInMb' ) * 1024;
//		if ( $count_file > 0 ) {
//			foreach ( $_FILES["attachments"]["name"] as $key => $value ) {
//				$rules[ "attachments." . $key ] = "max:$maxPost|mimes:png,gif,jpeg,jpg,psd,doc,docx,pdf,xls,xlsx,txt,zip,rar,php,html,css";
//			}
//		}
//
//		$rules["service_agreement"] = "required";
//		$payment_method             = $this->input( "payment_method", 1 );
//		if ( $payment_method == 2 || $payment_method == 3 ) {
//			$rules["card_number"] = "required";
//			$rules["card_cvv2"]   = "required";
//			$rules["card_expire"]   = ["required", new SmYearHypenMonth()];
//		}
               
		return $rules;
	}

	public function messages() {
		$messages                         = [];
		$messages['contact_email.unique'] = "Your account already exist by this email id, 
		Please logout guest account and Login by this email for better communication.";
		$count_file                       = count( $this->file( 'attachments' ) );
		$maxPost                          = config( 'constant.smPostMaxInMb' );
		if ( $count_file > 0 ) {
			foreach ( $_FILES["attachments"]["name"] as $key => $value ) {
				$messages[ 'attachments.' . $key . ".mimes" ] = "The file " . ( $value ) . " isn't allowed file type. Allowed file types are png,gif,jpeg,jpg,psd,doc,docx,pdf,xls,xlsx,txt,zip,rar,php,html,css";
				$messages[ 'attachments.' . $key . ".max" ]   = "The file " . ( $value ) . " upload size must be less then  $maxPost MB.";
			}
		}
		return $messages;
	}
}
