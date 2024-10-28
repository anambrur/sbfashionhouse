<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/15/18
 * Time: 3:07 PM
 */

namespace App\SM;


trait SM_PostType {
	private static $name;
	private static $path;
	private static $nameL;
	private static $namePlural;
	private static $namePluralL;
	private static $options;

	public static function createPostType( $name, $options = [] ) {
		self::$name = ucfirst( $name );
		self::$path = '';
		if ( preg_match( '/\//', self::$name ) ) {
			$fn = explode( '/', self::$name );
			if ( count( $fn ) < 3 ) {
				self::$name = ucfirst( $fn[1] );
				self::$path = ucfirst( $fn[0] );
			} else {
				self::$name = ucfirst( last( $fn ) );
				self::$path = ucfirst( $fn[0] );
			}
		}
		self::$options      = $options;
		self::$nameL        = strtolower( self::$name );
		self::$namePlural   = ucfirst( str_plural( self::$name ) );
		self::$namePluralL  = strtolower( self::$namePlural );
		$data['migration']  = self::createMigration();
		$data['model']      = self::createModel();
		$data['controller'] = self::createController();
		$data['views']      = self::createViews();

		return $data;
	}

	private static function createMigration() {
		$filename = date( "Y_m_d_His" ) . "_create_" . self::$namePlural . '_table.php';
		$file     = database_path( 'migrations' ) . DIRECTORY_SEPARATOR . $filename;
		if ( ! $new = fopen( $file, "w" ) ) {
			return false;
		} else {
			fwrite( $new, self::migrationText() );
			fclose( $new );

			return true;
		}
	}

	private static function createModel() {
		$filename = self::$name . '.php';
		$prepend  = app_path( 'Model' ) . DIRECTORY_SEPARATOR;
		$path     = self::createDir( $prepend );
		$file     = $prepend . $path . $filename;
		if ( ! $new = fopen( $file, "w" ) ) {
			return false;
		} else {
			fwrite( $new, self::modelText() );
			fclose( $new );

			return true;
		}
	}

	private static function createViews() {
		return false;
	}

	private static function createController() {
		$prepend = app_path( 'Http' . DIRECTORY_SEPARATOR . 'Controllers' ) . DIRECTORY_SEPARATOR;
		$path    = self::createDir( $prepend );
		$file    = $prepend . $path . self::$namePlural . '.php';
		if ( ! $new = fopen( $file, "w" ) ) {
			return false;
		} else {
			fwrite( $new, self::controllerText() );
			fclose( $new );

			return true;
		}
	}

	private static function createDir( $prepend ) {
		if ( self::$path != '' ) {
			if ( file_exists( $prepend . self::$path ) ) {
				return self::$path . DIRECTORY_SEPARATOR;
			} elseif ( mkdir( $prepend . self::$path ) ) {
				return self::$path . DIRECTORY_SEPARATOR;

			} else {
				echo "Directory Create failed!";

				return '';
			}

		} else {
			return '';
		}
	}


	private static function controllerText() {
		$op = '<?php
				
namespace App\Http\Controllers\\' . self::$path . ';

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\\' . ( self::$path != '' ? self::$path . '\\' : '' ) . self::$name . ';
use App\SM\SM;

class ' . self::$namePlural . ' extends Controller {
	/**
	 * Display a listing of the ' . self::$nameL . '.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data[\'rightButton\'][\'iconClass\'] = \'fa fa-plus\';
		$data[\'rightButton\'][\'text\']      = \'Add ' . self::$name . '\';
		$data[\'rightButton\'][\'link\']      = \'' . self::$namePluralL . '/create\';
		$data[\'all_' . self::$nameL . '\']                  = ' . self::$name . '::orderBy( "id", "desc" )
		                                       ->paginate( config( "constant.smPagination" ) );
		if ( \request()->ajax() ) {
			$json[\'data\']         = view( \'nptl-admin/common/' . self::$nameL . '/' . self::$namePluralL . '\', $data )->render();
			$json[\'smPagination\'] = view( \'nptl-admin/common/common/pagination_links\', [
				\'smPagination\' => $data[\'all_' . self::$nameL . '\']
			] )->render();

			return response()->json( $json );
		}

		return view( "nptl-admin/common/' . self::$nameL . '/manage_' . self::$nameL . '", $data );
	}

	/**
	 * Show the form for creating a new ' . self::$nameL . '.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data[\'rightButton\'][\'iconClass\'] = \'fa fa-list\';
		$data[\'rightButton\'][\'text\']      = \'' . self::$name . ' List\';
		$data[\'rightButton\'][\'link\']      = \'' . self::$namePluralL . '\';

		return view( "nptl-admin/common/' . self::$nameL . '/add_' . self::$nameL . '", $data );
	}

	/**
	 * Store a newly created ' . self::$nameL . ' in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$this->validate( $request, [
			\'title\'            => \'required\'
		] );
		$' . self::$nameL . '                   = new ' . self::$name . '();
		$' . self::$nameL . '->title            = $request->title;
		$' . self::$nameL . '->description      = $request->description;
		$' . self::$nameL . '->meta_key         = $request->meta_key;
		$' . self::$nameL . '->meta_description = $request->meta_description;

		if ( SM::is_admin() || isset( $permission ) &&
		                       isset( $permission[\'' . self::$namePluralL . '\'][\'' . self::$nameL . '_status_update\'] )
		                       && $permission[\'' . self::$namePluralL . '\'][\'' . self::$nameL . '_status_update\'] == 1 ) {
			$' . self::$nameL . '->status = $request->status;
		}
		if ( isset( $request->image ) && $request->image != \'\' ) {
			$' . self::$nameL . '->image = $request->image;
		}

		$slug            = ( trim( $request->slug ) != \'\' ) ? $request->slug : $request->title;
		$' . self::$nameL . '->slug       = SM::create_uri( \'' . self::$namePluralL . '\', $slug );
		$' . self::$nameL . '->created_by = SM::current_user_id();
		$' . self::$nameL . '->save();

		return redirect( SM::smAdminSlug( \'' . self::$namePluralL . '\' ) )
			->with( \'s_message\', \'' . self::$name . ' created successfully!\' );

	}

	/**
	 * Display the specified ' . self::$nameL . '.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
//	public function show( $id ) {
//		//
//	}

	/**
	 * Show the form for editing the specified ' . self::$nameL . '.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$data[\'' . self::$nameL . '_info\'] = ' . self::$name . '::find( $id );
		if ( count( $data[\'' . self::$nameL . '_info\'] ) > 0 ) {
			$data[\'rightButton\'][\'iconClass\'] = \'fa fa-list\';
			$data[\'rightButton\'][\'text\']      = \'' . self::$name . ' List\';
			$data[\'rightButton\'][\'link\']      = \'' . self::$namePluralL . '\';

			return view( \'nptl-admin/common/' . self::$nameL . '/edit_' . self::$nameL . '\', $data );
		} else {
			return redirect( SM::smAdminSlug( "' . self::$namePluralL . '" ) )
				->with( "w_message", "No ' . self::$nameL . ' Found!" );
		}
	}

	/**
	 * Update the specified ' . self::$nameL . ' in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		$this->validate( $request, [
			\'title\'            => \'required\'
		] );
		$' . self::$nameL . ' = ' . self::$name . '::find( $id );
		if ( count( $' . self::$nameL . ' ) > 0 ) {
			$' . self::$nameL . '->title            = $request->title;
			$' . self::$nameL . '->description      = $request->description;
			$' . self::$nameL . '->meta_key         = $request->meta_key;
			$' . self::$nameL . '->meta_description = $request->meta_description;

			if ( SM::is_admin() || isset( $permission ) &&
			                       isset( $permission[\'' . self::$namePluralL . '\'][\'' . self::$nameL . '_status_update\'] )
			                       && $permission[\'' . self::$namePluralL . '\'][\'' . self::$nameL . '_status_update\'] == 1 ) {
				$' . self::$nameL . '->status = $request->status;
			}
			if ( isset( $request->image ) && $request->image != \'\' ) {
				$' . self::$nameL . '->image = $request->image;
			}

			$slug             = ( trim( $request->slug ) != \'\' ) ? $request->slug : $request->title;
			$' . self::$nameL . '->slug        = SM::create_uri( \'' . self::$namePluralL . '\', $slug, $id );
			$' . self::$nameL . '->modified_by = SM::current_user_id();
			$' . self::$nameL . '->update();

			return redirect( SM::smAdminSlug( \'' . self::$namePluralL . '\' ) )
				->with( \'s_message\', \'' . self::$name . ' updated successfully!\' );
		} else {
			return redirect( SM::smAdminSlug( "' . self::$namePluralL . '" ) )
				->with( "w_message", "No ' . self::$nameL . ' Found!" );
		}
	}

	/**
	 * Remove the specified ' . self::$nameL . ' from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$' . self::$nameL . ' = ' . self::$name . '::find( $id );
		if ( count( $' . self::$nameL . ' ) > 0 ) {
			$' . self::$nameL . '->delete();

			echo 1;
			exit;
		} else {
			echo 0;
			exit;
		}
	}

	/**
	 * status change the specified ' . self::$nameL . ' from storage.
	 *
	 * @param  Request $request
	 *
	 * @return null
	 */
	public function ' . self::$nameL . '_status_update( Request $request ) {
		$this->validate( $request, [
			"post_id" => "required",
			"status"  => "required",
		] );

		$' . self::$nameL . ' = ' . self::$name . '::find( $request->post_id );
		if ( count( $' . self::$nameL . ' ) > 0 ) {
			$' . self::$nameL . '->status = $request->status;
			$' . self::$nameL . '->update();
		}
		exit;
	}
}';

		return $op;
	}

	private static function migrationText() {
		$op = '<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create' . self::$namePlural . 'Table extends Migration
{
    /**
     * Run the migrations for ' . self::$name . '.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\'' . self::$namePluralL . '\', function (Blueprint $table) {
	        $table->increments(\'id\');
	        $table->string(\'title\', 255)->index();
	        $table->text(\'description\')->nullable();
	        $table->string(\'image\')->nullable();
	        $table->string(\'slug\')->unique();
	        $table->string(\'meta_key\')->nullable();
	        $table->string(\'meta_description\')->nullable();
	        $table->integer(\'created_by\')->index()->unsigned()->nullable();
	        $table->integer(\'modified_by\')->unsigned()->nullable();
	        $table->tinyInteger(\'status\')->index()->default(2)->comment(\'1=active, 2=pending, 3=cancel\');
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations ' . self::$name . '.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\'' . self::$namePluralL . '\');
    }
}';

		return $op;
	}

	private static function modelText() {
		$op = '<?php

namespace App\Model\\' . self::$path . ';

use Illuminate\Database\Eloquent\Model;

class ' . self::$name . ' extends Model
{

}';

		return $op;
	}
}