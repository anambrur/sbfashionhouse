<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Slider;
use App\SM\SM;

class Sliders extends Controller {
	function sliders() {
		$data['rightButton']['iconClass'] = 'fa fa-plus';
		$data['rightButton']['text']      = 'Add Slider';
		$data['rightButton']['link']      = 'sliders/add_slider';
		$data['sliders']                  = Slider::orderBy( 'id', 'desc' )
		                                          ->paginate( config( 'constant.smPagination' ) );
		if ( \request()->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/slider/slider_list', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['sliders']
			] )->render();

			return response()->json( $json );
		}

		return view( 'nptl-admin/common/slider/sliders', $data );
	}

	function add_slider() {
		$data['rightButton']['iconClass'] = 'fa fa-sliders';
		$data['rightButton']['text']      = 'Slider List';
		$data['rightButton']['link']      = 'sliders';

		return view( 'nptl-admin/common/slider/add_slider', $data );
	}

	function save_slider( Request $data ) {
		$this->validate( $data, [
			'title' => 'required',
			'image' => 'required',
			'style' => 'required'
		] );
		$slider = new Slider();
		if ( isset( $data['image'] ) && $data['image'] != '' ) {
			$slider->image = $data['image'];
		}
		$slider->title       = $data['title'];
		$slider->description = $data->input( "description", "" );
		$slider->style       = $data['style'];
		$slider->extra       = SM::sm_serialize( $data['buttion'] );
		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['sliders']['slider_status_update'] )
		                       && $permission['sliders']['slider_status_update'] == 1 ) {
			$slider->status = $data->status;
		}
		$slider->status = $data['status'];

		$slider->created_by = SM::current_user_id();


		if ( $slider->save() ) {
			$this->removeThisCache();

			return redirect( config( 'constant.smAdminSlug' ) . '/sliders/edit_slider/' . $slider->id )->with( 's_message', 'Sliders successfully added!' );
		} else {
			return redirect( config( 'constant.smAdminSlug' ) . '/sliders' )->with( 's_message', 'Sliders Save Failed!' );
		}
	}

	function edit_slider( $id ) {
		$data['rightButton']['iconClass'] = 'fa fa-sliders';
		$data['rightButton']['text']      = 'Slider List';
		$data['rightButton']['link']      = 'sliders';
		$data['slider']                   = Slider::find( $id );
		$data['slider']->extra            = SM::sm_unserialize( $data['slider']->extra );

		return view( 'nptl-admin/common/slider/edit_slider', $data );
	}

	function update_slider( Request $data, $id ) {
		$this->validate( $data, [
			'title' => 'required',
			'image' => 'required',
			'style' => 'required'
		] );

		$slider = Slider::find( $id );
		if ( $slider ) {
			if ( isset( $data['image'] ) && $data['image'] != '' ) {
				$slider->image = $data['image'];
			}
			$slider->title       = $data['title'];
			$slider->description = $data->input( "description", "" );
			$slider->style       = $data['style'];
			$slider->extra       = SM::sm_serialize( $data['buttion'] );
			if ( SM::is_admin() || isset( $permission ) &&
			                       isset( $permission['sliders']['slider_status_update'] )
			                       && $permission['sliders']['slider_status_update'] == 1 ) {
				$slider->status = $data->status;
			}

			$slider->modified_by = SM::current_user_id();

			if ( $slider->update() ) {
				$this->removeThisCache();

				return redirect( config( 'constant.smAdminSlug' ) . '/sliders/edit_slider/' . $id )
					->with( 's_message', 'Sliders updated successfully!' );
			} else {
				return redirect( config( 'constant.smAdminSlug' ) . '/sliders' )
					->with( 's_message', 'Sliders Update Failed!' );
			}
		} else {
			return redirect( config( 'constant.smAdminSlug' ) . '/sliders' )->with( 'w_message', 'Sliders update error occurred!' );
		}
	}

	public function delete_slider( $id ) {
		$slider = Slider::find( $id );
		if ( $slider ) {
			if ( $slider->delete() > 0 ) {
				$this->removeThisCache();

				return response( 1 );
			}
		}

		return response( 0 );
	}

	public function slider_status_update( Request $data ) {
		$slider         = Slider::find( $data['post_id'] );
		$slider->status = $data['status'];
		$slider->save();
		$this->removeThisCache();
		echo 1;
	}

	private function removeThisCache() {
		SM::removeCache( 'homeSlider' );
	}
}
