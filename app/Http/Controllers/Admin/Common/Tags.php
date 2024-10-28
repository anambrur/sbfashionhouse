<?php
namespace App\Http\Controllers\Admin\Common;
use App\Model\Common\Taggable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Tag;
use App\SM\SM;

class Tags extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data['rightButton']['iconClass'] = 'fa fa-plus';
		$data['rightButton']['text']      = 'Add Tag';
		$data['rightButton']['link']      = 'tags/create';
		$data['all_tag']                  = Tag::orderBy( "id", "desc" )
		                                       ->paginate( config( "constant.smPagination" ) );
		if ( \request()->ajax() ) {
			$json['data']         = view( 'nptl-admin/common/tag/tags', $data )->render();
			$json['smPagination'] = view( 'nptl-admin/common/common/pagination_links', [
				'smPagination' => $data['all_tag']
			] )->render();

			return response()->json( $json );
		}

		return view( "nptl-admin/common/tag/manage_tag", $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['rightButton']['iconClass'] = 'fa fa-tags';
		$data['rightButton']['text']      = 'Tag List';
		$data['rightButton']['link']      = 'tags';

		return view( "nptl-admin/common/tag/add_tag", $data );
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
			'seo_title'        => 'max:70',
			'meta_description' => 'max:215'
		] );
		$tag                   = new Tag();
		$tag->title            = $request->title;
		$tag->description      = $request->description;
		$tag->seo_title        = $request->input( "seo_title", "" );
		$tag->meta_key         = $request->input( "meta_key", "" );
		$tag->meta_description = $request->input( "meta_description", "" );

		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission['tags']['tag_status_update'] )
		                       && $permission['tags']['tag_status_update'] == 1 ) {
			$tag->status = $request->status;
		}
		if ( isset( $request->image ) && $request->image != '' ) {
			$tag->image = $request->image;
		}

		$slug            = ( trim( $request->slug ) != '' ) ? $request->slug : $request->title;
		$tag->slug       = SM::create_uri( 'tags', $slug );
		$tag->created_by = SM::current_user_id();

		if ( $tag->save() ) {
			$this->removeThisCache();

			return redirect( SM::smAdminSlug( "tags/$tag->id/edit" ) )
				->with( 's_message', 'Tag created successfully!' );
		} else {
			return redirect( SM::smAdminSlug( 'tags' ) )
				->with( 's_message', 'Tag Save Failed!' );
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
		$data['tag_info'] = Tag::find( $id );
		if ( count( $data['tag_info'] ) > 0 ) {
			$data['rightButton']['iconClass']  = 'fa fa-tags';
			$data['rightButton']['text']       = 'Tag List';
			$data['rightButton']['link']       = 'tags';
			$data['rightButton2']['iconClass'] = 'fa fa-eye';
			$data['rightButton2']['text']      = 'View';
			$data['rightButton2']['link']      = "product/tag/" . $data['tag_info']->slug;

			return view( 'nptl-admin/common/tag/edit_tag', $data );
		} else {
			return redirect( SM::smAdminSlug( "tags" ) )
				->with( "w_message", "No tag Found!" );
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
			'title'            => 'required',
			'seo_title'        => 'max:70',
			'meta_description' => 'max:215'
		] );
		$tag = Tag::find( $id );
		if ( count( $tag ) > 0 ) {
			$this->removeThisCache( $tag->slug );
			$tag->title            = $request->title;
			$tag->description      = $request->description;
			$tag->seo_title        = $request->input( "seo_title", "" );
			$tag->meta_key         = $request->input( "meta_key", "" );
			$tag->meta_description = $request->input( "meta_description", "" );

			if ( SM::is_admin() || isset( $permission ) &&
			                       isset( $permission['tags']['tag_status_update'] )
			                       && $permission['tags']['tag_status_update'] == 1 ) {
				$tag->status = $request->status;
			}
			if ( isset( $request->image ) && $request->image != '' ) {
				$tag->image = $request->image;
			}

			$slug             = ( trim( $request->slug ) != '' ) ? $request->slug : $request->title;
			$tag->slug        = SM::create_uri( 'tags', $slug, $id );
			$tag->modified_by = SM::current_user_id();
			if ( $tag->update() ) {
				$this->removeThisCache();

				return redirect( SM::smAdminSlug( "tags/$tag->id/edit" ) )
					->with( 's_message', 'Tag Updated successfully!' );
			} else {
				return redirect( SM::smAdminSlug( "tags/$tag->id/edit" ) )
					->with( 's_message', 'Tag Update Failed!' );
			}
		} else {
			return redirect( SM::smAdminSlug( "tags" ) )
				->with( "w_message", "No tag Found!" );
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
		$tag = Tag::find( $id );
		if ( $tag ) {
			$tagables = Taggable::where( 'tag_id', $id )->get();
			if ( count( $tagables ) > 0 ) {
				foreach ( $tagables as $tagable ) {
					$tagable->delete();
				}
			}
			$this->removeThisCache( $tag->slug );
			if ( $tag->delete() > 0 ) {
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
	public function tag_status_update( Request $request ) {
		$this->validate( $request, [
			"post_id" => "required",
			"status"  => "required",
		] );

		$tag = Tag::find( $request->post_id );
		if ( count( $tag ) > 0 ) {
			$tag->status = $request->status;
			$tag->update();
			$this->removeThisCache( $tag->slug );
		}
		exit;
	}

	private function removeThisCache( $slug = null ) {
		if ( $slug != null ) {
			SM::removeCache( 'tag_' . $slug );
		}
		SM::removeCache( 'tags_have_posts' );
		SM::removeCache( 'tags_have_not_post' );
		SM::removeCache( [ 'tag' ], 1 );
		SM::removeCache( [ 'tagBlogs' ], 1 );
	}
}
