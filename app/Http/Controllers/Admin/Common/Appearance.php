<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Package;
use App\Model\Common\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Page;
use App\Model\Common\Slider;
use App\SM\SM;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Appearance extends Controller {

	public function smThemeOptions() {
		$file = resource_path( "views/smThemeOptions.php" );
		if ( file_exists( $file ) ) {
			$smThemeOptions = require_once $file;
		} else {
			$smThemeOptions = array();
		}

		return view( 'nptl-admin/common/appearance/sm-theme-options', [
			"smThemeOptions" => $smThemeOptions
		] );
	}

	public function saveSmThemeOptions( Request $request ) {
		$this->validate( $request, [ "sm_theme_options" => "required|array" ] );
		foreach ( $request->sm_theme_options as $section => $fields ) {
			foreach ( $fields as $settingKey => $settingValue ) {
				$newFormattedSettingValue = [];
				foreach ( $settingValue as $key => $value ) {
					if ( is_array( $value ) ) {
						$newLoop=[];
						foreach ($value as $single){
							$newLoop[]= json_decode($single, true);
						}
						$newFormattedSettingValue[ $key ] = $newLoop;
					} else {
						$newFormattedSettingValue[ $key ] = $value;
					}
				}
				$setting_option_name = "sm_theme_options_$settingKey";
				$smoption            = SM::sm_serialize( $newFormattedSettingValue, array() );
				SM::update_setting( $setting_option_name, $smoption );
			}
		}
		if ( $request->isXmlHttpRequest() ) {
			return response( "Successfully Saved!", 200 );
		} else {
			return back()->with( "s_message", "Successfully Saved!" );
		}
	}

	function menus() {
		$data['pages']     = Page::where( 'status', 1 )->get();
                $data['categories']     = \App\Model\Common\Category::where( 'status', 1 )->get();
		$data['main_menu'] = SM::sm_unserialize( SM::get_setting_value( 'main_menu' ) );

		return view( 'nptl-admin/common/appearance/menus', $data );
	}

	function save_menus( Request $data ) {
		if ( isset( $_POST ) ) {
			unset( $_POST['_token'] );
			$option_value = SM::sm_serialize( $_POST );
			$update       = SM::update_setting( 'main_menu', $option_value );
			echo $update;
		} else {
			echo 0;
		}
		exit;
	}
	/**
	 * Show File editor and file
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function editor( Request $request ) {
		if ( $request->ajax() ) {
			if ( $request->method() == 'POST' ) {
				/**
				 * Show file info
				 */
				if ( $request->has( 'dir' ) && $request->has( 'filename' ) ) {
					$dir      = $request->input( 'dir' );
					$filename = $request->input( 'filename' );
					$file     = $dir . DIRECTORY_SEPARATOR . $filename;
					if ( File::hash( $file ) ) {
						$data['isSuccess'] = 1;
						$data['contents']  = File::get( $file );
					} else {
						$data['isSuccess'] = 0;
						$data['message']   = "File not found!";
					}
				} else {
					$data['isSuccess'] = 0;
					$data['message']   = "Filename or Directory not found!";
				}

				return response()->json( $data );
			} else {
				/**
				 * Return directory info
				 */
				return response( $this->generateTreeHtml( $request ) );
			}
		} else {
			/**
			 * Return editor layout
			 */
			return view( 'nptl-admin/common/appearance/editor/editor' );
		}
	}


	private function generateTreeHtml( Request $request ) {
		$body        = '';
		$path        = $request->input( "directory", base_path() );
		$directories = File::directories( $path );
		if ( count( $directories ) > 0 ) {
			foreach ( $directories as $dir ) {
				$name = basename( $dir );
				$body .= '<li class="jstree-closed" data-is-dir="1" data-dir="' . $dir . '">' . $name . '</li>';
			}
		}
		$files = File::files( $path );
		if ( count( $files ) > 0 ) {
			foreach ( $files as $file ) {
				$name              = $file->getFilename();
				$ext               = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
				$icon              = $this->getFileIcon( $ext );
				$checkEditableFile = $this->checkEditableFile( $ext );
				$path              = $file->getPath();
				$body              .= '<li ';
				$body              .= 'data-jstree=\'{"icon":"' . $icon . '"}\' ';
				$body              .= 'data-is-dir="0" ';
				$body              .= 'data-dir="' . $path . '" ';
				$body              .= 'data-iswritable="' . $checkEditableFile['isAllowedEditableFile'] . '" ';
				$body              .= 'data-type="' . $checkEditableFile['type'] . '" ';
				$body              .= 'data-filename="' . $name . '" ';
				$body              .= '>' . $name . '</li>';
			}
		}
		if ( $request->has( "directory" ) ) {
			$header = '<ul>';
			$footer = '</ul>';
			$html   = $header . $body . $footer;
		} else {
			$header = '<li data-jstree=\'{"opened":true,"selected":true}\'>' . SM::sm_get_site_name();
			$header .= '<ul>';
			$footer = '</ul>';
			$footer .= '</li>';
			$html   = $header . $body . $footer;
		}

		return $html;
	}

	private function getFileIcon( $ext ) {
		$icon = 'file.png';
		if ( $ext == 'php' ) {
			$icon = 'php.png';
		} elseif ( $ext == 'css' ) {
			$icon = 'css.png';
		} elseif ( $ext == 'js' ) {
			$icon = 'js.png';
		} elseif ( $ext == 'json' ) {
			$icon = 'json.png';
		} elseif ( $ext == 'html' || $ext == 'htm' ) {
			$icon = 'html.png';
		} elseif ( $ext == 'md' ) {
			$icon = 'md.png';
		} elseif ( $ext == 'xml' ) {
			$icon = 'xml.png';
		}

		return asset( 'nptl-admin/img/file_icon/' . $icon );
	}

	private function checkEditableFile( $ext ) {
		if ( $ext == 'php' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'php';
		} elseif ( $ext == 'css' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'css';
		} elseif ( $ext == 'js' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'javascript';
		} elseif ( $ext == 'html' || $ext == 'html' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'html';
		} elseif ( $ext == 'md' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'markdown';
		} elseif ( $ext == 'json' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'json';
		} elseif ( $ext == 'xml' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'xml';
		} elseif ( $ext == 'log' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'log';
		}  else {
			$data['isAllowedEditableFile'] = 0;
			$data['type']                  = '';
		}

		return $data;
	}

	public function updateFile( Request $request ) {
		if ( $request->has( 'dir' ) && $request->has( 'filename' ) ) {
			$dir               = $request->input( 'dir' );
			$filename          = $request->input( 'filename' );
			$ext               = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
			$checkEditableFile = $this->checkEditableFile( $ext );
			if ( $checkEditableFile['isAllowedEditableFile'] == 1 ) {
				$file = $dir . DIRECTORY_SEPARATOR . $filename;
				if ( File::hash( $file ) ) {
					$content       = $request->input( 'content' );
					$bytes_written = File::put( $file, $content );
					if ( $bytes_written === false ) {
						$data['isSuccess'] = 0;
						$data['message']   = "File Written Failed!";
					} else {
						$data['isSuccess'] = 1;
						$data['message']   = ucfirst( $filename ) . " file updated successfully!";
					}
				} else {
					$data['isSuccess'] = 0;
					$data['message']   = "File not found!";
				}
			} else {
				$data['isSuccess'] = 0;
				$data['message']   = "We don't support this file update";
			}
		} else {
			$data['isSuccess'] = 0;
			$data['message']   = "Filename or Directory not found!";
		}

		return response()->json( $data );
	}
}