<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Payment_method;
use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentMethods extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data['rightButton']['iconClass'] = 'fa fa-plus';
		$data['rightButton']['text']      = 'Add Payment Method';
		$data['rightButton']['link']      = 'payment_methods/create';
		$data['all_payment_method']       = Payment_method::orderBy( "id", "desc" )
		                                                  ->paginate( config( "constant.smPagination" ) );
		if ( \request()->ajax() ) {
			$json['data']       = view( 'nptl-admin/common/payment_method/payment_methods', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['all_payment_method']
			] )->render();

			return response()->json( $json );
		}
		return view( "nptl-admin/common/payment_method/manage_payment_method", $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['rightButton']['iconClass'] = 'fa fa-credit-card';
		$data['rightButton']['text']      = 'Payment Methods';
		$data['rightButton']['link']      = 'payment_methods';

		return view( "nptl-admin/common/payment_method/add_payment_method", $data );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$rules = [
			'title'            => 'required',
			"meta_key"         => "max:160",
			"meta_description" => "max:160"
		];
		$type  = $request->input( "type", 1 );
		if ( $type == 2 || $type == 3 ) {
			$rules['api_key'] = 'required';
			$rules['api_secret'] = 'required';
		}
		$this->validate( $request, $rules );
		$payment_method              = new Payment_method();
		$payment_method->title       = $request->title;
		$payment_method->api_key     = $request->api_key;
		$payment_method->api_secret  = $request->api_secret;
		$payment_method->description = $request->description;
		$payment_method->type        = $type;
		$payment_method->mode        = $request->input( "mode", 'sandbox');

		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['paymentmethods']['payment_method_status_update'] )
		                       && $permission['paymentmethods']['payment_method_status_update'] == 1 ) {
			$payment_method->status = $request->status;
		}
		if ( isset( $request->image ) && $request->image != '' ) {
			$payment_method->image = $request->image;
		}

		$payment_method->created_by = SM::current_user_id();
		$payment_method->save();

		return redirect( SM::smAdminSlug( 'payment_methods' ) )
			->with( 's_message', 'Payment_method created successfully!' );

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
//	public function show( $id ) {
//		//
//	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$data['rightButton']['iconClass'] = 'fa fa-credit-card';
		$data['rightButton']['text']      = 'Payment Methods';
		$data['rightButton']['link']      = 'payment_methods';
		$data['payment_method_info']      = Payment_method::find( $id );
		if ( count((array)$data['payment_method_info'] ) > 0 ) {
			return view( 'nptl-admin/common/payment_method/edit_payment_method', $data );
		} else {
			return redirect( SM::smAdminSlug( "payment_methods" ) )
				->with( "w_message", "No payment_method Found!" );
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		$rules = [
			'title'            => 'required',
			"meta_key"         => "max:160",
			"meta_description" => "max:160"
		];
		$type  = $request->input( "type", 1 );
		if ( $type == 2 || $type == 3 ) {
			$rules['api_key'] = 'required';
			$rules['api_secret'] = 'required';
		}
		$this->validate( $request, $rules );
		$payment_method = Payment_method::find( $id );
		if ( count((array)$payment_method ) > 0 ) {
			$payment_method->title       = $request->title;
			$payment_method->api_key     = $request->api_key;
			$payment_method->api_secret  = $request->api_secret;
			$payment_method->description = $request->description;
			$payment_method->type        = $request->input( "type", 1 );
			$payment_method->mode        = $request->input( "mode", 'sandbox');

			if ( SM::is_admin() || isset( $permission ) &&
			                       isset( $permission['paymentmethods']['payment_method_status_update'] )
			                       && $permission['paymentmethods']['payment_method_status_update'] == 1 ) {
				$payment_method->status = $request->status;
			}
			if ( isset( $request->image ) && $request->image != '' ) {
				$payment_method->image = $request->image;
			}

			$payment_method->modified_by = SM::current_user_id();
			$payment_method->update();

			return redirect( SM::smAdminSlug( 'payment_methods' ) )
				->with( 's_message', 'Payment_method updated successfully!' );
		} else {
			return redirect( SM::smAdminSlug( "payment_methods" ) )
				->with( "w_message", "No payment_method Found!" );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$payment_method = Payment_method::find( $id );
		if ( count((array)$payment_method ) > 0 ) {
			$payment_method->delete();

			echo 1;
			exit;
		} else {
			echo 0;
			exit;
		}
	}

	/**
	 * status change the specified resource from storage.
	 *
	 * @param  Request $request
	 *
	 * @return null
	 */
	public function payment_method_status_update( Request $request ) {
		$this->validate( $request, [
			"post_id" => "required",
			"status"  => "required",
		] );

		$payment_method = Payment_method::find( $request->post_id );
		if ( count((array)$payment_method ) > 0 ) {
			$payment_method->status = $request->status;
			$payment_method->update();
		}
		exit;
	}
}
