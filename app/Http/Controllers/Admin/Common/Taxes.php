<?php

namespace App\Http\Controllers\Admin\Common;

use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Tax;

class Taxes extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data['rightButton']['iconClass'] = 'fa fa-plus';
		$data['rightButton']['text']      = 'Add Tax';
		$data['rightButton']['link']      = 'taxes/create';
		$data['all_tax']                  = Tax::orderBy( "id", "desc" )
		                                       ->paginate( config( "constant.smPagination" ) );
		if ( \request()->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/tax/taxes', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['all_tax']
			] )->render();

			return response()->json( $json );
		}

		return view( "nptl-admin/common/tax/manage_tax", $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['rightButton']['iconClass'] = 'fa fa-money';
		$data['rightButton']['text']      = 'Tax List';
		$data['rightButton']['link']      = 'taxes';

		return view( "nptl-admin/common/tax/add_tax", $data );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$this->validate( $request, [
			'title'   => 'required',
			"country" => "required|unique:taxes",
			"tax"     => "required|numeric",
			"type"    => "required|integer",
		] );
		$tax          = new Tax();
		$tax->title   = $request->title;
		$tax->country = $request->country;
		$tax->tax     = $request->tax;
		$tax->type    = $request->type;
		$permission   = SM::current_user_permission_array();
		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['tax']['tax_status_update'] )
		                       && $permission['tax']['tax_status_update'] == 1 ) {
			$tax->status = $request->status;
		}
		$tax->created_by = SM::current_user_id();
		if ( $tax->save() ) {
			return redirect( SM::smAdminSlug( "taxes/$tax->id/edit" ) )
				->with( 's_message', 'Tax Created Successfully!' );
		} else {
			return redirect( SM::smAdminSlug( "taxes" ) )
				->with( 's_message', 'Tax Save Failed!' );
		}
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
		$data["tax_info"] = Tax::find( $id );
		if ( count( $data["tax_info"] ) > 0 ) {
			$data['rightButton']['iconClass'] = 'fa fa-thumbs-up';
			$data['rightButton']['text']      = 'Tax List';
			$data['rightButton']['link']      = 'taxes';

			return view( "nptl-admin/common/tax/edit_tax", $data );
		} else {
			return redirect( SM::smAdminSlug( 'taxes' ) )
				->with( 's_message', 'Tax not found!' );
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
		$this->validate( $request, [
			'title'   => 'required',
			"country" => "required|unique:taxes,country," . $id,
			"tax"     => "required|numeric",
			"type"    => "required|integer",
		] );
		$tax = Tax::find( $id );
		if ( count( $tax ) > 0 ) {
			$tax->title   = $request->title;
			$tax->country = $request->country;
			$tax->tax     = $request->tax;
			$tax->type    = $request->type;
			$permission   = SM::current_user_permission_array();
			if ( SM::is_admin() || isset( $permission ) &&
			                       isset( $permission['tax']['tax_status_update'] )
			                       && $permission['tax']['tax_status_update'] == 1 ) {
				$tax->status = $request->status;
			}
			$tax->modified_by = SM::current_user_id();
			if ( $tax->update() > 0 ) {
				return redirect( SM::smAdminSlug( "taxes/$tax->id/edit" ) )
					->with( 's_message', 'Tax Update Successfully!' );
			} else {
				return redirect( SM::smAdminSlug( "taxes/$tax->id/edit" ) )
					->with( 's_message', 'Tax Update Failed!' );
			}
		} else {
			return redirect( SM::smAdminSlug( 'taxes' ) )
				->with( 'w_message', 'Tax not found!' );
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
		$tax = Tax::find( $id );
		if ( count( $tax ) > 0 ) {
			$tax->delete();

			if ( $tax->delete() > 0 ) {
				return response( 1 );
			}
		}

		return response( 0 );
	}

	/**
	 * status change the specified resource from storage.
	 *
	 * @param  Request $request
	 *
	 * @return null
	 */
	public function tax_status_update( Request $request ) {
		$this->validate( $request, [
			"post_id" => "required",
			"status"  => "required",
		] );

		$tax = Tax::find( $request->post_id );
		if ( count( $tax ) > 0 ) {
			$tax->status = $request->status;
			$tax->update();
		}
		exit;
	}
}
