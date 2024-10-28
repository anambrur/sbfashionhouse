<?php

namespace App\SM;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Model\Blog_category as Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Admin as Admin_model;
use App\Model\Common\Admins_meta;
use App\Model\Common\Role;
use App\SM\SM;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Session;

/**
 * This class is provide you all current user and admin realted info.
 * @author Engr. Mizanur Rahman Khan Sohag <engr.mrksohag@gmail.com>
 * @copyright (c) 2016, Engr. Mizanur Rahman Khan Sohag
 * @created_date 03-25-2016
 * @modified_date 03-25-2016
 */
trait SM_Admin {

	private static $currentUserPermissionResult;

	public static function smAdminSlug( $segment = null ) {
		$smAdminSlug = config( 'constant.smAdminSlug' );
		if ( $segment != null ) {
			return $smAdminSlug . '/' . $segment;
		}

		return $smAdminSlug;
	}
	public static function smAdminUrl( $segment = null ) {
		return url(self::smAdminSlug($segment));
	}

	/**
	 * This method is for get current admin user details
	 * @return object
	 */
	public static function current_user_details() {
		$admin = auth()->guard( 'admins' );
		if ( $admin->check() ) {
			return $admin->user();
		}
	}

	/**
	 *  This method will provide curret user id
	 * @return int id
	 */
	public static function current_user_id() {
		if ( isset( self::current_user_details()['id'] ) ) {
			return self::current_user_details()['id'];
		} else {
			return 0;
		}
	}

	/**
	 *  This method will provide curret username
	 * @return string username
	 */
	public static function current_username() {
		return self::current_user_details()['username'];
	}

	/**
	 *  This method will provide curret user email
	 * @return string email
	 */
	public static function current_user_email() {
		return self::current_user_details()['email'];
	}

	/**
	 *  This method will provide curret user role id
	 * @return int role id
	 */
	public static function current_user_role() {
		return self::current_user_details()['role_id'];
	}

	/**
	 *  This method will provide curret user role name
	 * @return int role id
	 */
	public static function current_user_role_name() {
		return self::get_user_role_name( self::current_user_details()['role_id'] );
	}

	/**
	 *  This method will provide curret user role permission
	 * @return array role permission
	 */
	public static function current_user_permission_array() {
		if ( static::$currentUserPermissionResult ) {
			$result = static::$currentUserPermissionResult;
		} else {
//			Debugbar::info( "current_user_permission_array else " );
			$result = static::$currentUserPermissionResult = Role::find( self::current_user_role() );
		}
		if ( $result ) {
			return $permission = SM::sm_unserialize( $result->permission );
		} else {
			return array();
		}
	}

	/**
	 *  This method will provide curret user image name
	 * @return int image name
	 */
	public static function current_user_image() {
		return self::current_user_details()['image'];
	}

	/**
	 *  This method will provide curret user created date time
	 * @return string date time
	 */
	public static function current_user_created_at() {
		return self::current_user_details()['created_at'];
	}

	/**
	 *  This method will provide you current admin meta value
	 *
	 * @param string $meta_key Give your meta_key
	 *
	 * @return string $meta_value meta_value
	 */
	public static function current_user_meta( $meta_key ) {
		$admin_meta = Admins_meta::where( 'admin_id', self::current_user_id() )
		                         ->where( 'meta_key', $meta_key )
		                         ->first();
		if ( $admin_meta ) {
			return $admin_meta->meta_value;
		} else {
			return '';
		}
	}

	/**
	 *  This method will provide you current admin user firstname and last name if empty then username
	 *
	 * @param string $meta_key Give your meta_key
	 *
	 * @return string $meta_value meta_value
	 */
	public static function current_user_first_lastname() {
		$fl = self::current_user_details()['firstname'] . ' ' . self::current_user_details()['lastname'];

		return ! SM::sm_string( $fl ) ? self::current_username() : $fl;
	}

	/**
	 *  This method will update admin meta if not found then it will add new admin meta by user_id, meta key and meta value
	 *
	 * @param int $user_id Give your user_id
	 * @param string $meta_key Give your meta_key
	 * @param string $meta_value Give your meta_value
	 *
	 * @return sting
	 */
	public static function update_user_meta( $user_id, $meta_key, $meta_value ) {
		$admin_meta = Admins_meta::where( 'admin_id', $user_id )
		                         ->where( 'meta_key', $meta_key )
		                         ->first();
		if ( $admin_meta ) {
			$admin_meta->meta_value = $meta_value;
			$admin_meta->save();
		} else {
			Admins_meta::create( [
				'admin_id'   => $user_id,
				'meta_key'   => $meta_key,
				'meta_value' => $meta_value,
			] );
		}
	}

	/**
	 *  This method will provide you admin user_info
	 *
	 * @param int $user_id Give your user_id
	 *
	 * @return object user object
	 */
	public static function get_user_info( $user_id ) {
		return Admin_model::find( $user_id );
	}

	/**
	 *  This method will provide you admin meta value
	 *
	 * @param int $user_id Give your admin id
	 * @param string $meta_key Give your meta_key
	 *
	 * @return string $meta_value meta_value
	 */
	public static function get_user_meta( $user_id, $meta_key ) {
		$admin_meta = Admins_meta::where( 'admin_id', $user_id )
		                         ->where( 'meta_key', $meta_key )
		                         ->first();
		if ( $admin_meta ) {
			return $admin_meta->meta_value;
		} else {
			return '';
		}
	}

	/**
	 *  This method will provide you admin meta value
	 *
	 * @param int $user_id Give your admin id
	 * @param string $meta_key Give your meta_key
	 *
	 * @return string $meta_value meta_value
	 */
	public static function get_user_first_lastname( $user_id, $user_name = null ) {
		if ( $user_name == null ) {
			$user_name = self::get_user_info( $user_id );
		}
		$fl_name = $user_name->firstname . ' ' . $user_name->lastname;

		return trim( $fl_name ) != '' ? $fl_name : $user_name->username;
	}

	public static function is_admin() {
		if ( self::current_user_role() == 1 ) {
			return true;
		} else {
			return false;
		}
	}


	private static $methods = array(
		'save_page',
		'update_page',
		'save_blog',
		'update_blog',
		'save_category',
		'update_category',
		'update_comment',
		'save_reply',
		'savesmthemeoptions',
		'save_menus',
		'save_slider',
		'update_slider',
		'save_user',
		'update_user',
		'save_role',
		'update_role',
		'save_setting',
		'save_social',
		'save_fb_credential',
		'save_gp_credential',
		'save_tt_credential',
		'save_li_credential',
		'store',
		'update',
		'payment_status_update',
		'payment_info_update',
		'searchuser',
		'searchpackage',
	);


	public static function check_current_url_user_access() {
		if ( ! self::is_admin() ) {
			$controller = strtolower( SM::current_controller() );
			$method     = strtolower( SM::current_method() );

			$method_array = self::$methods;
			if ( $controller != 'dashboard' && self::check_this_contoller_access( $controller ) ) {
				if ( in_array( $method, $method_array ) || self::check_this_method_access( $controller, $method ) ) {
					return true;
				}
			}
			return false;

		}

		return true;
	}

	public static function check_this_contoller_access( $controller ) {
		$permission = self::current_user_permission_array();
		if ( self::is_admin() || ( isset( $permission[ $controller ] ) && is_array( $permission[ $controller ] ) ) ) {
			if ( self::is_admin() || ( isset( $permission[ $controller ][ $controller ] ) && $permission[ $controller ][ $controller ] == 1 ) ) {
				return true;
			}
		}

		return false;
	}

	public static function check_this_method_access( $controller, $method ) {
		$permission = self::current_user_permission_array();
		if ( self::is_admin() || ( isset( $permission[ $controller ] ) && is_array( $permission[ $controller ] ) ) ) {
			if ( self::is_admin() || ( isset( $permission[ $controller ][ $method ] ) && $permission[ $controller ][ $method ] == 1 ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 *  This method will check access permission if have then return true else false
	 *
	 * @param array $roles roles array or integer value
	 *
	 * @return bool true false
	 */
	public static function check_user_role( $roles ) {
		if ( isset( $roles ) && is_array( $roles ) ) {
			foreach ( $roles as $role ) {
				if ( $role == self::current_user_role() ) {
					return true;
				}
			}
		} elseif ( isset( $roles ) && is_integer( $roles ) ) {
			if ( $roles == self::current_user_role() ) {
				return true;
			}
		}

		return false;
	}

	/**
	 *  This method will check access permission reverse if have then return false else true
	 *
	 * @param array $roles roles array or integer value
	 *
	 * @return bool true false
	 */
	public static function check_ruser_role( $roles ) {
		if ( isset( $roles ) && is_array( $roles ) ) {
			foreach ( $roles as $role ) {
				if ( $role == self::current_user_role() ) {
					return false;
				}
			}
		} elseif ( isset( $roles ) && is_integer( $roles ) ) {
			if ( $roles == self::current_user_role() ) {
				return false;
			}
		}

		return true;
	}

	/**
	 *  This method will check access permission if have then return true else redirct to denied page
	 *
	 * @param array $roles roles array or integer value
	 *
	 * @return bool true false
	 */
	public static function check_user_role_r( $roles ) {
		if ( self::check_user_role( $roles ) ) {
			return true;
		}

		return redirect( config( 'constant.smAdminSlug' ) . '/access_denied' )->with( 'w_message', "You don't have permission to see this page" );
	}

	/**
	 *  This method will check access permission reverse if have then return false else redirct to denied page
	 *
	 * @param array $roles roles array or integer value
	 *
	 * @return bool true false
	 */
	public static function check_ruser_role_r( $roles ) {
		if ( self::check_ruser_role( $roles ) ) {
			return false;
		}

		return redirect( config( 'constant.smAdminSlug' ) . '/access_denied' );
	}

	/**
	 *  This method will provide you all role options that you can use in select feild
	 * @return string role options
	 */
	public static function get_user_role_option() {
		$roles = Role::all();
		$data  = '';
		if ( $roles ) {
			foreach ( $roles as $role ) {
				$data .= '<option value="' . $role->id . '">' . $role->name . '</option>';
			}
		}

		return $data;
	}

	/**
	 *  This method will provide you user role name by role id
	 * @return string user role name
	 */
	public static function get_user_role_name( $role_id ) {
		$role = Role::find( $role_id );
		if ( $role ) {
			return $role->name;
		}
	}


	public static function generateRoleHtml( $name, $controller, $methods, $permissions ) {
		$html = '<div class="col col-3 user_role">
                <label class="label"><b>' . $name . ' Management</b></label>';
		foreach ( $methods as $method => $title ) {
			$title = ( $title != '' ) ? $title : ucwords( str_replace( '_', ' ', $method ) . ' ' . $name );
			$html  .= '<label class="checkbox">
                    <input type="checkbox" name="permission[' . $controller . '][' . $method . ']" 
                    ' . ( is_array( $permissions ) && isset( $permissions[ $method ] ) && $permissions[ $method ] == 1 ? 'checked ' : '' ) . 'value="1">
                    <i></i>' . $title . '</label>';
		}
		$html .= '</div > ';

		return $html;
	}

}
