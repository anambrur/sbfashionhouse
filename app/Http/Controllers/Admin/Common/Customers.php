<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Blog;
use App\Model\Common\Comment;
use App\Model\Common\Order;
use App\Model\Common\Order_detail;
use App\Model\Common\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Common\Users_meta;
use App\SM\SM;
use App\Model\Common\Media;
use Illuminate\Support\Facades\Auth;

class Customers extends Controller {

	public function index( Request $request ) {
		$data['rightButton']['iconClass'] = 'fa fa-user';
		$data['rightButton']['text']      = 'Add Customer';
		$data['rightButton']['link']      = 'customers/add_customer';
		$data['min']                      = $request->input( 'min', '' );
		$data['max']                      = $request->input( 'max', '' );
		$data['status']                   = $request->input( 'status', '' );
		$data['customer']                 = $request->input( 'customer', '' );
		$data['cid']                      = $request->input( 'cid', '' );

		$query = User::orderBy( 'users.id', 'desc' );

		if ( $data['min'] != '' ) {
			$query->where( 'total_paid', '>=', $data['min'] );
		}
		if ( $data['max'] != '' ) {
			$query->where( 'total_paid', '<=', $data['max'] );
		}
		if ( $data['status'] != '' ) {
			$query->where( 'status', '=', $data['status'] );
		}
		if ( $data['cid'] != '' ) {
			$query->where( 'id', '=', $data['cid'] );
		} else {
			$data['customer'] = '';
		}

		$data['users'] = $query->paginate( config( 'constant.smPagination' ) );
		if ( $request->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/customers/customers', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['users']
			] )->render();

			return response()->json( $json );
		}

		return view( 'nptl-admin/common/customers/manage_user', $data );
	}

	public function add_customer() {
		$data['rightButton']['iconClass'] = 'fa fa-users';
		$data['rightButton']['text']      = 'Customer List';
		$data['rightButton']['link']      = 'customers';

		return view( 'nptl-admin/common/customers/add_user', $data );
	}

	public function save_customer( Request $data ) {
		$this->validate( $data, [
			'username'  => 'required|min:6|max:50|unique:users',
			'email'     => 'required|email|max:255|unique:users',
			'password'  => 'required|confirmed|min:6',
			'firstname' => 'required',
			'lastname'  => 'required',
			'mobile'    => 'required|unique:users',
			'street'    => 'required',
			'city'      => 'required',
			'zip'       => 'required',
			'state'     => 'required',
			'country'   => 'required',
		] );

		$user            = new User();
		$user->username  = $data['username'];
		$user->email     = $data['email'];
		$user->firstname = isset( $data['firstname'] ) ? $data['firstname'] : null;
		$user->lastname  = isset( $data['lastname'] ) ? $data['lastname'] : null;
		$user->mobile    = isset( $data['mobile'] ) ? $data['mobile'] : null;

		$user->password = bcrypt( $data['password'] );
		if ( isset( $data['image'] ) && $data['image'] != '' ) {
			$user->image = $data['image'];
		}
		$user->street  = isset( $data['street'] ) ? $data['street'] : null;
		$user->city    = isset( $data['city'] ) ? $data['city'] : null;
		$user->zip     = isset( $data['zip'] ) ? $data['zip'] : null;
		$user->state   = isset( $data['state'] ) ? $data['state'] : null;
		$user->country = isset( $data['country'] ) ? $data['country'] : null;
		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['customers']['customer_status_update'] )
		                       && $permission['customers']['customer_status_update'] == 1 ) {
			$user->status = $data->status;
		}
		$user->save();

		$user_id = $user->id;

		$value = isset( $data['mobile2'] ) ? $data['mobile2'] : null;
		SM::update_front_user_meta( $user_id, 'mobile2', $value );


		$value = isset( $data['gender'] ) ? $data['gender'] : null;
		SM::update_front_user_meta( $user_id, 'gender', $value );


		$value = isset( $data['skype'] ) ? $data['skype'] : null;
		SM::update_front_user_meta( $user_id, 'skype', $value );


		$value = isset( $data['whats_app'] ) ? $data['whats_app'] : null;
		SM::update_front_user_meta( $user_id, 'whats_app', $value );


		$value = isset( $data['extra_note'] ) ? $data['extra_note'] : null;
		SM::update_front_user_meta( $user_id, 'extra_note', $value );

		return redirect( config( 'constant.smAdminSlug' ) . '/customers' )
			->with( 's_message', 'Customer created successfully!' );
	}

	public function edit_customer( $id ) {
		$data['user'] = User::find( $id );
		$user_meta    = Users_meta::where( 'user_id', $id )->get();
		if ( count((array)$user_meta ) ) {
			$data['rightButton']['iconClass'] = 'fa fa-users';
			$data['rightButton']['text']      = 'Customer List';
			$data['rightButton']['link']      = 'customers';
			foreach ( $user_meta as $meta ) {
				$key                = $meta->meta_key;
				$data['user']->$key = $meta->meta_value;
			}
		}
		unset( $data['user']->password );

		return view( 'nptl-admin/common/customers/edit_user', $data );
	}

	public function update_customer( Request $data, $id ) {
		$this->validate( $data, [
			'firstname' => 'required',
			'lastname'  => 'required',
			'password'  => 'confirmed',
			'mobile'    => 'required',
			'street'    => 'required',
			'city'      => 'required',
			'zip'       => 'required',
			'state'     => 'required',
			'country'   => 'required'
		] );
		$user_id = $id;

		$user = User::find( $user_id );

		if ( isset( $data['image'] ) && $data['image'] != '' ) {
			$user->image = $data['image'];
		}
		if ( isset( $data['password'] ) && $data['password'] != '' && $data['password'] == $data['password_confirmation'] ) {
			$user->password = bcrypt( $data['password'] );
		}
		$user->mobile  = isset( $data['mobile'] ) ? $data['mobile'] : null;
		$user->street  = isset( $data['street'] ) ? $data['street'] : null;
		$user->city    = isset( $data['city'] ) ? $data['city'] : null;
		$user->zip     = isset( $data['zip'] ) ? $data['zip'] : null;
		$user->state   = isset( $data['state'] ) ? $data['state'] : null;
		$user->country = isset( $data['country'] ) ? $data['country'] : null;
		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['customers']['customer_status_update'] )
		                       && $permission['customers']['customer_status_update'] == 1 ) {
			$user->status = $data->status;
		}

		$user->firstname = isset( $data['firstname'] ) ? $data['firstname'] : null;
		$user->lastname  = isset( $data['lastname'] ) ? $data['lastname'] : null;
		$user->update();

		$value = isset( $data['mobile2'] ) ? $data['mobile2'] : null;
		SM::update_front_user_meta( $user_id, 'mobile2', $value );

		$value = isset( $data['gender'] ) ? $data['gender'] : null;
		SM::update_front_user_meta( $user_id, 'gender', $value );


		$value = isset( $data['skype'] ) ? $data['skype'] : null;
		SM::update_front_user_meta( $user_id, 'skype', $value );


		$value = isset( $data['whats_app'] ) ? $data['whats_app'] : null;
		SM::update_front_user_meta( $user_id, 'whats_app', $value );

		$value = isset( $data['extra_note'] ) ? $data['extra_note'] : null;
		SM::update_front_user_meta( $user_id, 'extra_note', $value );

		return redirect( config( 'constant.smAdminSlug' ) . '/customers' )->with( 's_message', 'Customer updated successfully!' );
	}

	public function delete_customer( $id ) {
		$user = User::find( $id );
		if ( $user ) {
			$path       = config( 'constant.smUploadsDir' );
			$all_width  = config( 'constant.smImgWidth' );
			$all_height = config( 'constant.smImgHeight' );
			$medias     = Media::where( 'created_by', $id )->get();
			if ( count((array)$medias ) > 0 ) {
				foreach ( $medias as $media ) {
					SM::sm_file_delete( $all_width, $all_height, $path, $media->id );
				}
			}
			Users_meta::where( 'user_id', $id )->delete();
			$user->delete();

			$orders = Order::where( "user_id", $id )->get();
			if ( count((array)$orders ) > 0 ) {
				foreach ( $orders as $order ) {
					if ( $order->package_type == 2 ) {
						Order_detail::where( "order_id", $order->id )->delete();
					}
					$order->delete();
				}
			}

			$comments = Comment::where( "created_by", $id )->get();
			if ( count((array)$comments ) > 0 ) {
				foreach ( $comments as $comment ) {
					if ( $comment->commentable_type == 'App\Model\Common\Blog' ) {
						$blog = Blog::find( $comment->commentable_id );
						if ( $blog && $blog->comments > 0 ) {
							$blog->decrement( 'comments' );
						}
						$comment->delete();
					}
				}
			}
			echo 1;
			exit;
		} else {
			echo 0;
			exit;
		}
	}

	public function customer_status_update( Request $data ) {
		$user         = User::find( $data['post_id'] );
		$user->status = $data['status'];
		$user->save();
		echo 1;
	}

	public function check_username( Request $data ) {
		$username = $data['username'];
		$user     = User::where( 'username', $username )->first();
		if ( isset( $user ) && count((array)$user ) > 0 ) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function check_email( Request $data ) {
		$username = $data['email'];
		$user     = User::where( 'email', $username )->first();
		if ( isset( $user ) && count((array)$user ) > 0 ) {
			echo 1;
		} else {
			echo 0;
		}
	}
}
