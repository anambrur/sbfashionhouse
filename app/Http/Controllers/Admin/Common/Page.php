<?php

namespace App\Http\Controllers\Admin\Common;

use foo\bar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Page as Page_model;
use App\Model\Common\Role;
use App\SM\SM;
use Illuminate\Support\Facades\Auth;

class Page extends Controller {
	function index() {
		$data['rightButton']['iconClass'] = 'fa fa-plus';
		$data['rightButton']['text']      = 'Add Page';
		$data['rightButton']['link']      = 'pages/add_page';
		$data['pages']                    = Page_model::orderBy( 'created_at', 'desc' )
		                                              ->paginate( config( 'constant.smPagination' ) );
		if ( \request()->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/page/pages', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['pages']
			] )->render();

			return response()->json( $json );
		}

		return view( 'nptl-admin/common/page/manage_page', $data );
	}

	function add_page() {
		$data['rightButton']['iconClass'] = 'fa fa-pagelines';
		$data['rightButton']['text']      = 'Page List';
		$data['rightButton']['link']      = 'pages';

		return view( 'nptl-admin/common/page/add_page', $data );
	}

	function save_page( Request $data ) {
		$this->validate( $data, [
			'menu_title'       => 'required|min:2|max:20',
			'page_title'       => 'required|min:2|max:100',
			'content'          => 'required',
			'seo_title'        => 'max:70',
			'meta_description' => 'max:215'
		] );
		$page                = new Page_model();
		$page->menu_title    = $data['menu_title'];
		$page->page_title    = $data['page_title'];
		$page->page_subtitle = $data['page_subtitle'];
		if ( isset( $data->image ) && $data->image != '' ) {
			$page->banner_image = $data->image;
		}
		$page->content = $data['content'];
		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['page']['page_status_update'] )
		                       && $permission['page']['page_status_update'] == 1 ) {
			$page->status = $data->status;
		}

		$page->banner_title     = $data->input( "banner_title", "" );
		$page->banner_subtitle  = $data->input( "banner_subtitle", "" );
		$page->seo_title        = $data->input( "seo_title", "" );
		$page->meta_key         = $data['meta_key'];
		$page->meta_description = $data['meta_description'];
		$page->created_by       = SM::current_user_id();
		$slug                   = ( trim( $data->slug ) != '' ) ? $data->slug : $data->title;
		$page->slug             = SM::create_uri( 'pages', $slug );

		if ( $page->save() ) {
			$this->removeThisCache();

			return redirect( config( 'constant.smAdminSlug' ) . '/pages' )->with( 's_message', 'Page successfully created!' );
		} else {
			return redirect( config( 'constant.smAdminSlug' ) . '/pages' )->with( 'w_message', 'Page Save Failed!' );
		}


	}

	function edit_page( $id ) {
		$data['page_info'] = Page_model::find( $id );
		if ( $data['page_info'] ) {
			$data['rightButton']['iconClass']  = 'fa fa-pagelines';
			$data['rightButton']['text']       = 'Page List';
			$data['rightButton']['link']       = 'pages';
			$data['rightButton2']['iconClass'] = 'fa fa-eye';
			$data['rightButton2']['text']      = 'View';
			$data['rightButton2']['link']      = $data['page_info']->slug;

			return view( 'nptl-admin/common/page/edit_page', $data );
		} else {
			return back()->with( "w_message", "No Page Found!" );
		}
	}

	function update_page( Request $data, $id ) {
		$this->validate( $data, [
			'menu_title'       => 'required|min:2|max:20',
			'page_title'       => 'required|min:2|max:100',
			'content'          => 'required',
			'seo_title'        => 'max:70',
			'meta_description' => 'max:215'
		] );
		$page = Page_model::find( $id );
		if ( $page ) {
			$this->removeThisCache( $page->slug );
			$page->menu_title      = $data['menu_title'];
			$page->page_title      = $data['page_title'];
			$page->page_subtitle   = $data['page_subtitle'];
			$page->banner_title    = $data->input( "banner_title", "" );
			$page->banner_subtitle = $data->input( "banner_subtitle", "" );
			if ( isset( $data->image ) && $data->image != '' ) {
				$page->banner_image = $data->image;
			}
			$page->content = $data['content'];
			if ( SM::is_admin() || isset( $permission ) &&
			                       isset( $permission['page']['page_status_update'] )
			                       && $permission['page']['page_status_update'] == 1 ) {
				$page->status = $data->status;
			}
			$page->seo_title        = $data->input( "seo_title", "" );
			$page->meta_key         = $data['meta_key'];
			$page->meta_description = $data['meta_description'];
			$page->modified_by      = SM::current_user_id();
			$slug                   = ( trim( $data->slug ) != '' ) ? $data->slug : $data->title;
			$page->slug             = SM::create_uri( 'pages', $slug, $id );
			$updateCount            = $page->update();
			if ( $updateCount > 0 ) {
				return redirect( config( 'constant.smAdminSlug' ) . '/pages' )->with( 's_message', 'Page updated successfully!' );
			} else {
				return redirect( config( 'constant.smAdminSlug' ) . '/pages' )->with( 'w_message', 'Page update error occurs!' );
			}
		} else {
			return redirect( config( 'constant.smAdminSlug' ) . '/pages' )->with( 'w_message', 'Page update error occurs!' );
		}
	}

	public function delete_page( $id ) {
		$page = Page_model::find( $id );
		if ( $page ) {
			$this->removeThisCache( $page->slug );
			$page->delete();

			echo 1;
			exit;
		} else {
			echo 0;
			exit;
		}
	}

	public function page_status_update( Request $data ) {
		$page = Page_model::find( $data['post_id'] );
		if ( $page ) {
			$page->status = $data['status'];
			$page->save();
			$this->removeThisCache( $page->slug );
		}
		echo 1;
	}

	private function removeThisCache( $slug = null ) {
		if ( $slug != null ) {
			SM::removeCache( 'page_' . $slug );
		}
		SM::removeCache( [ 'page' ], 1 );
	}
}
