<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/30/17
 * Time: 2:22 PM
 */

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Blog;
use App\Model\Common\Category;
use App\Model\Common\Coupon;
use App\Model\Common\Package;
use App\Model\Common\Payment;
use App\Model\Common\Payment_method;
use App\Model\Common\Service;
use App\Model\Common\Tag;
use App\Model\Common\Tax;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Model\Common\Admins_meta;
use App\Model\Common\Role;
use App\SM\SM;
use App\Model\Common\Comment;
use App\Model\Common\Media;

class Users extends Controller {

	public function index() {
		$data['users'] = Admin::with('role')
		                      ->orderBy( 'id', 'desc' )
		                      ->paginate( config( 'constant.smPagination' ) );
		if ( \request()->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/users/users', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['users']
			] )->render();

			return response()->json( $json );
		}

		return view( 'nptl-admin/common/users/manage_user', $data );
	}

	public function add_user() {
		$data['roles'] = Role::where( "status", 1 )->get();

		return view( 'nptl-admin/common/users/add_user', $data );
	}

	public function save_user( Request $data ) {
		$this->validate( $data, [
			'username' => 'required|min:6|max:50|unique:admins',
			'email'    => 'required|email|max:255|unique:admins',
			'password' => 'required|confirmed|min:6',
			'role_id'  => 'required'
		] );
		$admin            = new Admin();
		$admin->username  = $data['username'];
		$admin->email     = $data['email'];
		$admin->firstname = isset( $data['firstname'] ) ? $data['firstname'] : null;
		$admin->lastname  = isset( $data['lastname'] ) ? $data['lastname'] : null;
		$admin->password  = bcrypt( $data['password'] );
		$admin->role_id   = $data['role_id'];
		if ( isset( $data['image'] ) && $data['image'] != '' ) {
			$admin->image = $data['image'];
		}

		$permission = SM::current_user_permission_array();
		if ( SM::is_admin() || isset( $permission ) && isset( $permission['users']['user_status_update'] ) && $permission['users']['user_status_update'] == 1 ) {
			$admin->status = $data['status'];
		}
		$admin->save();

		$user_id = $admin->id;


		$value = isset( $data['mobile'] ) ? $data['mobile'] : null;
		SM::update_user_meta( $user_id, 'mobile', $value );


		$value = isset( $data['gender'] ) ? $data['gender'] : null;
		SM::update_user_meta( $user_id, 'gender', $value );


		$value = isset( $data['skype'] ) ? $data['skype'] : null;
		SM::update_user_meta( $user_id, 'skype', $value );


		$value = isset( $data['whats_app'] ) ? $data['whats_app'] : null;
		SM::update_user_meta( $user_id, 'whats_app', $value );


		$value = isset( $data['street'] ) ? $data['street'] : null;
		SM::update_user_meta( $user_id, 'street', $value );


		$value = isset( $data['city'] ) ? $data['city'] : null;
		SM::update_user_meta( $user_id, 'city', $value );

		$value = isset( $data['state'] ) ? $data['state'] : null;
		SM::update_front_user_meta( $user_id, 'state', $value );

		$value = isset( $data['zip'] ) ? $data['zip'] : null;
		SM::update_user_meta( $user_id, 'zip', $value );


		$value = isset( $data['country'] ) ? $data['country'] : null;
		SM::update_user_meta( $user_id, 'country', $value );


		$value = isset( $data['extra_note'] ) ? $data['extra_note'] : null;
		SM::update_user_meta( $user_id, 'extra_note', $value );

		return redirect( config( 'constant.smAdminSlug' ) . '/users' )->with( 's_message', 'User created successfully!' );
	}

	public function edit_user( $id ) {
		$data['roles'] = Role::where( "status", 1 )->get();
		$data['user']  = Admin::find( $id );
		$user_meta     = Admins_meta::where( 'admin_id', $id )->get();
		if ( count( $user_meta ) ) {
			foreach ( $user_meta as $meta ) {
				$key                = $meta->meta_key;
				$data['user']->$key = $meta->meta_value;
			}
		}
		unset( $data['user']->password );

		return view( 'nptl-admin/common/users/edit_user', $data );
	}

	public function update_user( Request $data, $id ) {
		$this->validate( $data, [
			'password' => 'confirmed',
			'role_id'  => 'required'
		] );
		$user_id = $id;

		$user = Admin::find( $user_id );

		if ( isset( $data['image'] ) && $data['image'] != '' ) {
			$user->image = $data['image'];
		}
		if ( isset( $data['password'] ) && $data['password'] != '' && $data['password'] == $data['password_confirmation'] ) {
			$user->password = bcrypt( $data['password'] );
		}
		$permission = SM::current_user_permission_array();
		if ( SM::is_admin() || isset( $permission ) && isset( $permission['users']['user_status_update'] ) && $permission['user']['user_status_update'] == 1 ) {
			$user->status = $data['status'];
		}

		$user->firstname = isset( $data['firstname'] ) ? $data['firstname'] : null;
		$user->lastname  = isset( $data['lastname'] ) ? $data['lastname'] : null;
		$user->role_id   = $data['role_id'];
		$user->update();

		$value = isset( $data['mobile'] ) ? $data['mobile'] : null;
		SM::update_user_meta( $user_id, 'mobile', $value );


		$value = isset( $data['gender'] ) ? $data['gender'] : null;
		SM::update_user_meta( $user_id, 'gender', $value );


		$value = isset( $data['skype'] ) ? $data['skype'] : null;
		SM::update_user_meta( $user_id, 'skype', $value );


		$value = isset( $data['whats_app'] ) ? $data['whats_app'] : null;
		SM::update_user_meta( $user_id, 'whats_app', $value );


		$value = isset( $data['street'] ) ? $data['street'] : null;
		SM::update_user_meta( $user_id, 'street', $value );


		$value = isset( $data['city'] ) ? $data['city'] : null;
		SM::update_user_meta( $user_id, 'city', $value );

		$value = isset( $data['state'] ) ? $data['state'] : null;
		SM::update_user_meta( $user_id, 'state', $value );

		$value = isset( $data['zip'] ) ? $data['zip'] : null;
		SM::update_user_meta( $user_id, 'zip', $value );


		$value = isset( $data['country'] ) ? $data['country'] : null;
		SM::update_user_meta( $user_id, 'country', $value );


		$value = isset( $data['extra_note'] ) ? $data['extra_note'] : null;
		SM::update_user_meta( $user_id, 'extra_note', $value );

		return redirect( config( 'constant.smAdminSlug' ) . '/users' )->with( 's_message', 'User updated successfully!' );
	}

	public function delete_user( $id ) {
		$user = Admin::find( $id );
		if ( $user ) {
			$path       = config( 'constant.smUploadsDir' );
			$all_width  = config( 'constant.smImgWidth' );
			$all_height = config( 'constant.smImgHeight' );
			$medias     = Media::where( 'created_by', $id )->get();
			if ( count( $medias ) > 0 ) {
				foreach ( $medias as $media ) {
					SM::sm_file_delete( $all_width, $all_height, $path, $media->id );
				}
			}

			$user_meta = Admins_meta::where( 'admin_id', $id )->delete();
			Comment::where( "created_by", $id )->delete();
			Package::where( "created_by", $id )->delete();
			Blog::where( "created_by", $id )->delete();
			\App\Model\Common\Cases::where( "created_by", $id )->delete();
			Category::where( "created_by", $id )->delete();
			Coupon::where( "created_by", $id )->delete();
			Payment_method::where( "created_by", $id )->delete();
			Service::where( "created_by", $id )->delete();
			Tag::where( "created_by", $id )->delete();
			Tax::where( "created_by", $id )->delete();
			\App\Model\Common\Page::where( "created_by", $id )->delete();
			$user->delete();

			echo 1;
			exit;
		} else {
			echo 0;
			exit;
		}
	}

	public function user_status_update( Request $data ) {
		$user         = Admin::find( $data['post_id'] );
		$user->status = $data['status'];
		$user->save();
		echo 1;
	}

	///role
	public function roles() {
		$data['roles'] = role::paginate( config( 'constant.smPagination' ) );
		if ( \request()->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/users/roles_list', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['roles']
			] )->render();

			return response()->json( $json );
		}

		return view( 'nptl-admin/common/users/manage_roles', $data );
	}

	public function add_role() {
		$data['role'] = array();

		return view( 'nptl-admin/common/users/add_role', $data );
	}

	public function save_role( Request $data ) {
		$per              = SM::sm_serialize( $data['permission'] );
		$role             = new Role;
		$role->name       = $data['role'];
		$role->permission = $per;
		$role->created_by = SM::current_user_id();
		$role->status     = 1;
		$role->save();

		return redirect( config( 'constant.smAdminSlug' ) . '/users/roles' )->with( 's_message', 'Successfully role created!' );
	}

	public function edit_role( $id ) {
		$data['role'] = Role::find( $id );

		return view( 'nptl-admin/common/users/edit_role', $data );
	}

	public function update_role( Request $data ) {
		$per               = SM::sm_serialize( $data['permission'] );
		$id                = $data['id'];
		$role              = Role::find( $id );
		$role->name        = $data['role'];
		$role->permission  = $per;
		$role->modified_by = SM::current_user_id();
		$role->update();

		return redirect( config( 'constant.smAdminSlug' ) . '/users/roles' )->with( 's_message', 'Successfully role updated!' );
	}

	public function delete_role( $id ) {
		$role = Role::find( $id );
		if ( $role ) {
			$data   = 'Successfully role deleted!';
			$admins = Admin::where( 'role_id', $id )->get();
			if ( $admins ) {
				$users = '';
				$i     = 0;
				foreach ( $admins as $admin ) {
					if ( $i > 0 ) {
						$users .= ', ';
					}
					$users         .= $admin->username;
					$admin->status = 2;
					$admin->role   = 0;
					$admin->save();
					$i ++;
				}
				if ( $users != '' ) {
					$data .= 'Please check these username like <b>' . $users . '</b> users has this role, those user status changed to pending. change those user role and status!';
				}
			}

			$role->delete();

			return response( $data, 200 );
		}
		echo 0;
		exit;
	}
}
