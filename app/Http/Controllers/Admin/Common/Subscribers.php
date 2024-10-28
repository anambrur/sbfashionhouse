<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Subscriber;
use App\SM\SM;
use Maatwebsite\Excel\Facades\Excel;

class Subscribers extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request ) {
		$data['rightButton']['iconClass'] = 'fa fa-plus';
		$data['rightButton']['text']      = 'Add Subscriber';
		$data['rightButton']['link']      = 'subscribers/create';
		$data['fullname']                 = $request->input( 'fullname', '' );
		$data['email']                    = $request->input( 'email', '' );
		$data['country']                  = $request->input( 'country', '' );
		$data['sstatus']                  = $request->input( 'sstatus', '' );
		$query                            = Subscriber::orderBy( "id", "desc" );
		if ( $data['fullname'] != '' ) {
			$query->where( function ( $query1 ) use ( $data ) {
				$query1->where( 'firstname', 'like', "%" . $data['fullname'] . "%" );
				$query1->orWhere( 'lastname', 'like', "%" . $data['fullname'] . "%" );
			} );
		}
		if ( $data['email'] != '' ) {
			$query->where( 'email', '=', $data['email'] );
		}
		if ( $data['sstatus'] != '' ) {
			$query->where( 'status', '=', $data['sstatus'] );
		}
		if ( $data['country'] != '' ) {
			$query->where( 'country', '=', $data['country'] );
		}
		$data['all_subscriber'] = $query->paginate( config( "constant.smPagination" ) );
		if ( \request()->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/subscriber/subscribers', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['all_subscriber']
			] )->render();

			return response()->json( $json );
		}
		if ( $request->has( 'excel' ) && $request->excel == 'excel' ) {
			$all_subscriber = $data['all_subscriber'];
			if ( count((array)$all_subscriber ) > 0 ) {
				Excel::create( 'buckleup_subscribers_' . date( 'YmdHis' ), function ( $excel ) use ( $all_subscriber ) {
					$excel->sheet( 'Subscribers ' . date( 'Y-m-d' ), function ( $sheet ) use ( $all_subscriber ) {
						$loop = 1;
						$sheet->mergeCells( "A$loop:D$loop" );
						$sheet->cells( "A$loop:D$loop", function ( $cells ) {
							$cells->setBackground( '#1d2d5d' );
							$cells->setFontColor( '#ffffff' );
							$cells->setFontSize( 18 );
							$cells->setAlignment( 'center' );
							$cells->setValignment( 'center' );
							// Set all borders (top, right, bottom, left)
							$cells->setBorder( 'none', 'none', 'solid', 'none' );

// Set borders with array
							$cells->setBorder( array(
								'bottom' => array(
									'style' => 'solid'
								),
							) );
						} );
						$single   = [];
						$single[] = 'buckleup Subscribers';
						$sheet->row( $loop, $single );
						$sheet->getRowDimension( $loop )->setRowHeight( 40 );
						$loop ++;

						$single   = [];
						$single[] = 'Email';
						$single[] = 'Name';
						$single[] = 'Country';
						$single[] = 'State';
						$sheet->row( $loop, $single );
						$sheet->cells( "A$loop:D$loop", function ( $cells ) {
							$cells->setBackground( '#1d2d5d' );
							$cells->setFontColor( '#ffffff' );
							$cells->setFontSize( 12 );
							$cells->setAlignment( 'center' );
							$cells->setValignment( 'center' );
						} );
						$sheet->getRowDimension( $loop )->setRowHeight( 20 );
						$loop ++;
						$loop ++;
						foreach ( $all_subscriber as $subscriber ) {
							$single   = [];
							$single[] = $subscriber->email;
							$single[] = $subscriber->firstname . " " . $subscriber->lastname;
							$single[] = $subscriber->country;
							$single[] = $subscriber->state;

							$sheet->row( $loop, $single );
							$loop ++;
						}
						$loop ++;


						$single = [];
						$sheet->mergeCells( "A$loop:D$loop" );
						$sheet->cells( "A$loop:D$loop", function ( $cells ) {
							$cells->setBackground( '#1d2d5d' );
							$cells->setFontColor( '#ffffff' );
							$cells->setFontSize( 12 );
							$cells->setAlignment( 'center' );
							$cells->setValignment( 'center' );
						} );
						$single[0] = 'Developed by Engr. Mizanur Rahman Khan';
						$sheet->row( $loop, $single );


					} );

				} )->download( 'xlsx' );
			} else {
				return view( "nptl-admin/common/subscriber/manage_subscriber", $data );
			}
		} else {
			return view( "nptl-admin/common/subscriber/manage_subscriber", $data );
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['rightButton']['iconClass'] = 'fa fa-subscribers';
		$data['rightButton']['text']      = 'Subscriber List';
		$data['rightButton']['link']      = 'subscribers';

		return view( "nptl-admin/common/subscriber/add_subscriber", $data );
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
			'title'            => 'required',
			"meta_key"         => "max:160",
			"meta_description" => "max:160"
		] );
		$subscriber                   = new Subscriber();
		$subscriber->title            = $request->title;
		$subscriber->description      = $request->description;
		$subscriber->meta_key         = $request->meta_key;
		$subscriber->meta_description = $request->meta_description;

		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['subscribers']['subscriber_status_update'] )
		                       && $permission['subscribers']['subscriber_status_update'] == 1 ) {
			$subscriber->status = $request->status;
		}
		if ( isset( $request->image ) && $request->image != '' ) {
			$subscriber->image = $request->image;
		}

		$slug                   = ( trim( $request->slug ) != '' ) ? $request->slug : $request->title;
		$subscriber->slug       = SM::create_uri( 'subscribers', $slug );
		$subscriber->created_by = SM::current_user_id();
		$subscriber->save();

		return redirect( SM::smAdminSlug( 'subscribers' ) )
			->with( 's_message', 'Subscriber created successfully!' );

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
		$data['subscriber_info'] = Subscriber::find( $id );
		if ( count((array)$data['subscriber_info'] ) > 0 ) {
			$data['rightButton']['iconClass'] = 'fa fa-subscribers';
			$data['rightButton']['text']      = 'Subscriber List';
			$data['rightButton']['link']      = 'subscribers';

			return view( 'nptl-admin/common/subscriber/edit_subscriber', $data );
		} else {
			return redirect( SM::smAdminSlug( "subscribers" ) )
				->with( "w_message", "No subscriber Found!" );
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
			'email' => 'required|email|max:255|unique:subscribers,email,' . $id
		] );
		$subscriber = Subscriber::find( $id );
		if ( count((array)$subscriber ) > 0 ) {
			$subscriber->email     = $request->email;
			$subscriber->firstname = $request->firstname;
			$subscriber->lastname  = $request->lastname;
			$subscriber->state     = $request->state;
			$subscriber->country   = $request->country;
			$subscriber->city      = $request->city;
			$subscriber->extra     = $request->extra;

			if ( SM::is_admin() || isset( $permission ) &&
			                       isset( $permission['subscribers']['subscriber_status_update'] )
			                       && $permission['subscribers']['subscriber_status_update'] == 1 ) {
				$subscriber->status = $request->status;
			}
			$subscriber->update();

			return redirect( SM::smAdminSlug( 'subscribers' ) )
				->with( 's_message', 'Subscriber updated successfully!' );
		} else {
			return redirect( SM::smAdminSlug( "subscribers" ) )
				->with( "w_message", "No subscriber Found!" );
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
		$subscriber = Subscriber::find( $id );
		if ( count((array)$subscriber ) > 0 ) {
			$subscriber->delete();

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
	public function subscriber_status_update( Request $request ) {
		$this->validate( $request, [
			"post_id" => "required",
			"status"  => "required",
		] );

		$subscriber = Subscriber::find( $request->post_id );
		if ( count((array)$subscriber ) > 0 ) {
			$subscriber->status = $request->status;
			$subscriber->update();
			echo 1;
		}
		exit;
	}
}
