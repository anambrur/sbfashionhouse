<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 8/12/17
 * Time: 2:39 PM
 */

namespace App\SM;

use App\Model\Common\Setting;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Collective\Html\FormFacade as Form;

trait SM_Theme_Options {
	private static $smFieldName = array();

	public static function smGetThemeOption( $key, $smPropertyDefault = null ) {
		self::initThemeOptionData();
		if ( isset( static::$smFieldName[ $key ] ) && static::$smFieldName[ $key ] != '' ) {
			return static::$smFieldName[ $key ];
		} else {
			return $smPropertyDefault;
		}
	}

	public static function initThemeOptionData() {
		if ( count( static::$smFieldName ) == 0 ) {
			$smGetThemeOptionData = SM::smGetThemeOptionData();
			if ( is_array( $smGetThemeOptionData ) && count( $smGetThemeOptionData ) > 0 ) {
				foreach ( $smGetThemeOptionData as $section => $fields ) {
					$data                = SM::sm_unserialize( $fields );
					static::$smFieldName = array_merge( static::$smFieldName, $data );

				}
			}
		}
	}

	public static function smSwitchToType( $smProperty, $smPropertyId, $smPropertyLabel = null, $smPropertyDefault = null, $smPropertySection = null, $isPostOption = 0, $chaildren = 0 ) {
		if ( isset( $smProperty["type"] ) ) {
//			echo "<pre>smSwitchToType \n";
//			print_r( "smPropertyId $smPropertyId \n" );
//			print_r( "inputName $smPropertySection \n" );
//			print_r( $smProperty );
//			echo "</pre>";
			$type = $smProperty["type"];
			switch ( $type ) {
				case "tab":
					unset( $smProperty["type"] );
					unset( $smProperty["label"] );
					self::smTab( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "panel":
					self::smPanel( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "addable-popup":
					SM::smAddablePopup( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption, $chaildren );
					break;
				case "fields":
					self::smFields( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "text":
					self::smText( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "hidden":
					self::smHidden( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "textarea":
					self::smTextarea( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "number":
					self::smNumber( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "email":
					self::smEmail( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "password":
					self::smPassword( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "radio":
					self::smRadio( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "select":
					self::smSelect( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "checkbox":
					self::smCheckbox( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "switch":
					self::smSwitch( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "switch-option":
					self::smSwitchOption( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "slider":
					self::smSlider( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "upload":
					self::smUpload( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
				case "uploads":
					self::smUploads( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
					break;
			}
		}
	}

	public static function smTab( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
		$countSectionValue = count( $smProperty );
		if ( is_array( $smProperty ) && $countSectionValue > 0 ) {

			$smPropertySection = ( $smPropertySection != '' ) ? $smPropertySection : "sm_theme_options[$smPropertyId]";
			?>
            <div class="tabs-left" id="<?php echo $smPropertySection; ?>">
                <ul class="nav nav-tabs tabs-left" id="<?php echo $smPropertySection; ?>Ul">
					<?php
					$loop = 1;
					foreach ( $smProperty as $tabId => $tabValue ) {
						$label                = isset( $tabValue["label"] ) ? $tabValue["label"] : "Tab " . $loop;
						$smPropertySectionNew = $smPropertySection . "[$tabId]";
						$formattedId          = str_replace( ']', '_', str_replace( '[', '_', $smPropertySectionNew ) );
						?>
                        <li class="sm-tab-item <?php echo ( $loop == 1 ) ? "active" : ""; ?>"
                            id="sm-tab-item-<?php echo $formattedId; ?>">
                            <a href="#<?php echo $formattedId; ?>" data-toggle="tab"
                               aria-expanded="true"> <?php echo $label; ?></a>
                        </li>
						<?php
						$loop ++;
					}
					?>
                </ul>
                <div class="tab-content" id="<?php echo $smPropertySection; ?>Content">
					<?php
					$loop = 1;
					foreach ( $smProperty as $tabId => $tabValue ) {
						$label                = isset( $tabValue["label"] ) ? $tabValue["label"] : "Tab " . $loop;
						$smPropertySectionNew = $smPropertySection . "[$tabId]";
						$formattedId          = str_replace( ']', '_', str_replace( '[', '_', $smPropertySectionNew ) );
						?>
                        <div class="tab-pane <?php echo ( $loop == 1 ) ? "active" : ""; ?>"
                             id="<?php echo $formattedId; ?>">
							<?php
							self::smSwitchToType( $tabValue, $tabId, $label, null, $smPropertySectionNew );
							?>
                        </div>
						<?php
						$loop ++;
					}
					?>
                </div>
            </div>
            <div class="clearfix"></div>
			<?php
		}
	}

	public static function smPanel( $smProperty, $smPropertyId, $smPropertyLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {

//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		$countSectionValue = count( $smProperty );
		if ( is_array( $smProperty ) && $countSectionValue > 0 ) {
			?>
            <div class="panel-group smart-accordion-default" id="<?php echo $smPropertyId; ?>">
				<?php
				$loop = 1;
				foreach ( $smProperty as $tabId => $tabValue ) {
					$label = isset( $tabValue["label"] ) ? $tabValue["label"] : "Tab " . $loop;
					?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-2"
                                   href="#<?php echo $tabId; ?>" <?php echo ( $loop == 1 ) ? '' : 'class="collapsed"'; ?>>
                                    <i class="fa fa-fw fa-plus-circle txt-color-green"></i>
                                    <i class="fa fa-fw fa-minus-circle txt-color-red"></i>
									<?php echo $label; ?> </a>
                            </h4>
                        </div>
                        <div id="<?php echo $tabId; ?>"
                             class="panel-collapse collapse <?php echo ( $loop == 1 ) ? "in" : ""; ?>">
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
					<?php
					$loop ++;
				}
				?>
            </div>
            <div class="clearfix"></div>
			<?php
		}
	}

	public static function smFields( $fileds, $fieldId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		?>
        <div class="smthemefields" id="<?php echo $fieldId; ?>">
            <h3><?php echo $fieldLabel; ?></h3>


			<?php
			$countFileds = count( $fileds["fields"] );
			if ( $countFileds > 0 ) {
				foreach ( $fileds["fields"] as $filedId => $fieldInfo ) {
					self::smSwitchToType( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption );
				}
			}
			?>
        </div>
		<?php
	}

	public static function smText( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$label = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField = $smPropertySection . "[$filedId]";

		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";

		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::text( $nameField, $smPropertyDefault, $extra ); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

		<?php
	}

	public static function smHidden( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";

		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$extra["id"] = "sm_theme_options[$smPropertySection][$filedId]";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield hidden_field">
            <div class="col-md-2">
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::hidden( $nameField, $smPropertyDefault, $extra ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<?php
	}

	public static function smTextarea( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {

//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$label = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = stripslashes( self::smGetThemeOption( $filedId, $smPropertyDefault ) );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smTextarea \n";
////		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
////		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::textarea( $nameField, $smPropertyDefault, $extra ); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smEmail( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {

//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$label = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::email( $nameField, $smPropertyDefault, $extra ); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smNumber( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {

//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$label = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::number( $nameField, $smPropertyDefault, $extra ); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smPassword( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
//		echo "<pre>";
//		print_r( $fieldInfo );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$label = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
		}

		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::password( $nameField, $extra ); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smRadio( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " radio";
		} else {
			$extra["class"] = "radio";
		}
		$fields = isset( $fieldInfo["fields"] ) ? $fieldInfo["fields"] : array();
		$label  = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php
							$loop = 1;
							if ( is_array( $fields ) ) {
								foreach ( $fields as $field_key => $field_value ) {
									$isSelected = ( $smPropertyDefault == $field_key ) ? true : false;
									echo "<label>";
									$extra["id"] = $formattedId . $loop;
									echo Form::radio( $nameField, $field_key, $isSelected, $extra );
									echo $field_value . "</label><br>";
									$loop ++;
								}
							} elseif ( is_string( $fields ) ) {
								$isSelected = ( $smPropertyDefault == $fields ) ? true : false;
								echo "<label> ";
								echo Form::radio( $nameField, $fields, $isSelected, $extra );
								echo $fields . "</label><br>";
							} else {

							}
							?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smSelect( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$fields = isset( $fieldInfo["fields"] ) ? $fieldInfo["fields"] : array();
		$label  = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::select( $nameField, $fields, $smPropertyDefault, $extra ); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smCheckbox( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$fields = isset( $fieldInfo["fields"] ) ? $fieldInfo["fields"] : array();
		$label  = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php
							if ( is_array( $fields ) ) {
								foreach ( $fields as $field_key => $field_value ) {
									$isSelected = ( $smPropertyDefault == $field_key ) ? true : false;
									echo "<label> ";
									$extra["id"] = $formattedId . $field_key;
									echo Form::checkbox( $nameField, $field_key, $isSelected, $extra );
									echo " " . $field_value . "</label><br>";
								}
							} elseif ( is_string( $fields ) ) {
								$isSelected = ( $smPropertyDefault == $fields ) ? true : false;
								echo "<label> ";
								echo Form::checkbox( $nameField, $fields, $isSelected, $extra );
								echo $fields . "</label><br>";
							} else {

							}
							?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smSwitch( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " toggle";
		} else {
			$extra["class"] = "toggle";
		}
		$onText  = isset( $fieldInfo["on_text"] ) ? $fieldInfo["on_text"] : "On";
		$offText = isset( $fieldInfo["off_text"] ) ? $fieldInfo["off_text"] : "Off";
		$label   = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : true;
			$smPropertyDefault = ( $smPropertyDefault == true ) ? 1 : 0;
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $nameField, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="sm-switch">
								<?php
								$extra["class"] = $extra["class"] . " toggle-left";
								$extra["id"]    = $formattedId . "-toggle-on";
								$isSelected     = ( $smPropertyDefault == true ) ? true : false;
								echo Form::radio( $nameField, 1, $isSelected, $extra );
								echo '<label for="' . $formattedId . '-toggle-on" class="sm-toggle-btn">' . $onText . '</label>';


								$extra["class"] = $extra["class"] . " toggle-right";
								$extra["id"]    = $formattedId . "-toggle-off";
								$isSelected     = ( $smPropertyDefault != true ) ? true : false;
								echo Form::radio( $nameField, 0, $isSelected, $extra );
								echo '<label for="' . $formattedId . '-toggle-off" class="sm-toggle-btn">' . $offText . '</label>';
								?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smSwitchOption( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " toggle";
		} else {
			$extra["class"] = "toggle";
		}
		$onText  = isset( $fieldInfo["on_text"] ) ? $fieldInfo["on_text"] : "On";
		$offText = isset( $fieldInfo["off_text"] ) ? $fieldInfo["off_text"] : "Off";
		$label   = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : true;
			$smPropertyDefault = ( $smPropertyDefault == true ) ? 1 : 0;
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $nameField, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="sm-switch">
								<?php
								$extra["class"] = $extra["class"] . " toggle-left";
								$extra["id"]    = $formattedId . "-toggle-on";
								$isSelected     = ( $smPropertyDefault == true ) ? true : false;
								echo Form::radio( $nameField, 1, $isSelected, $extra );
								echo '<label for="' . $formattedId . '-toggle-on" class="sm-toggle-btn">' . $onText . '</label>';


								$extra["class"] = $extra["class"] . " toggle-right";
								$extra["id"]    = $formattedId . "-toggle-off";
								$isSelected     = ( $smPropertyDefault != true ) ? true : false;
								echo Form::radio( $nameField, 0, $isSelected, $extra );
								echo '<label for="' . $formattedId . '-toggle-off" class="sm-toggle-btn">' . $offText . '</label>';
								?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smSlider( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " slider slider-primary";
		} else {
			$extra["class"] = "slider slider-primary";
		}
		$label = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		$min   = isset( $fieldInfo["min"] ) ? $fieldInfo["min"] : 1;
		$max   = isset( $fieldInfo["max"] ) ? $fieldInfo["max"] : 20;
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$extra["data-slider-min"]    = $min;
		$extra["data-slider-max"]    = $max;
		$extra["data-slider-value"]  = $smPropertyDefault;
		$extra["data-slider-handle"] = "round";
		$nameField                   = $smPropertySection . "[$filedId]";
		$formattedId                 = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"]                 = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
							<?php echo Form::hidden( $nameField, $smPropertyDefault, $extra ); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smUpload( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {

//		echo "<pre>";
//		print_r( $smPropertySection );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$extra["data-type"] = "upload";
		$label              = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>
        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-2">
                        <div class="" id="<?php echo $filedId; ?>_input">
							<?php echo Form::hidden( $nameField, $smPropertyDefault, $extra ); ?>
                            <input input_holder="<?php echo $formattedId; ?>"
                                   img_holder="<?php echo $formattedId; ?>_ph"
                                   is_multiple="0"
                                   media_width="112" img_width="100" type="button"
                                   class="btn btn-primary btn-block sm_media_modal_show"
                                   value="Upload">
                        </div>
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						$file = SM::sm_get_galary_src_data_img( $smPropertyDefault, false );
						?>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="smthemesingleimagediv" id="<?php echo $formattedId; ?>_ph">
                                <img data-default="<?= $smPropertyDefault; ?>" class="media_img"
                                     src="<?php echo $file['src'] ?>"
                                     width="112px"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
		<?php
	}

	public static function smUploads( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0 ) {
//		echo "<pre>";
//		print_r( $fieldInfo );
//		echo "</pre>";
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$extra["data-type"] = "uploads";
		$label              = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$nameField   = $smPropertySection . "[$filedId]";
		$formattedId = str_replace( ']', '_', str_replace( '[', '_', $nameField ) );
		$extra["id"] = $formattedId;
//		echo "<pre>smText \n";
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "nameField $nameField\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";
		?>

        <div class="smthemeoptionfield">
            <div class="col-md-2">
				<?php echo Form::label( $formattedId, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
							<?php echo Form::hidden( $nameField, $smPropertyDefault, $extra ); ?>
                            <input input_holder="<?php echo $formattedId; ?>"
                                   img_holder="<?php echo $formattedId; ?>_ph"
                                   is_multiple="1"
                                   media_width="112" img_width="100" type="button"
                                   class="btn btn-primary btn-block sm_media_modal_show"
                                   value="Upload / Select File">
							<?php
							if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
								?>
                                <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
								<?php
							}
							?>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="smto_gallery" id="<?php echo $formattedId; ?>_ph">
								<?php
								if ( isset( $smPropertyDefault ) && $smPropertyDefault != '' ) {
									$image_array = [];
									if ( ! $image_array = explode( ',', $smPropertyDefault ) ) {
										$image_array = array( $smPropertyDefault );
									}
									if ( is_array( $image_array ) && count( $image_array ) > 0 ) {
										foreach ( $image_array as $img_id ) {
											if ( ! SM::sm_string( $img_id ) ) {
												continue;
											}
											$file = SM::sm_get_galary_src_data_img( $img_id, false );
											?>
                                            <span class="gl_img">
                                                 <img class=""
                                                      src="<?php echo $file['src']; ?>"
                                                      width="100px"/>
                                                 <span class="displayNone remove">
                                                     <i class="fa fa-times-circle remove_img"
                                                        data-img="<?php echo $img_id; ?>"
                                                        data-input_holder="<?php echo $formattedId; ?>"
                                                     ></i>
                                                 </span>
                                              </span>
											<?php
										}
									}
								}
								?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

		<?php
	}

	public static function smAddablePopup( $fieldInfo, $filedId, $fieldLabel, $smPropertyDefault, $smPropertySection, $isPostOption = 0, $chaildren = 0 ) {
		$chaildren ++;
		$extra = isset( $fieldInfo["extra"] ) ? $fieldInfo["extra"] : array();
		if ( isset( $extra["class"] ) ) {
			$extra["class"] = $extra["class"] . " form-control";
		} else {
			$extra["class"] = "form-control";
		}
		$label          = isset( $fieldInfo["label"] ) ? $fieldInfo["label"] : "Label";
		$single_title   = isset( $fieldInfo["single_title"] ) ? $fieldInfo["single_title"] : "Title";
		$add_more_title = isset( $fieldInfo["add_more_title"] ) ? $fieldInfo["add_more_title"] : "Add More";
		$template       = isset( $fieldInfo["template"] ) ? $fieldInfo["template"] : "";
		if ( $isPostOption == 0 ) {
			$smPropertyDefault = isset( $fieldInfo["default"] ) ? $fieldInfo["default"] : "";
			$smPropertyDefault = self::smGetThemeOption( $filedId, $smPropertyDefault );
		}
		$smPropertySection = ( $smPropertySection != '' ) ? $smPropertySection . "[$filedId]" : "sm_theme_options[$filedId]";
		$formattedId       = str_replace( ']', '_', str_replace( '[', '_', $smPropertySection ) );
//		echo "<pre>smAddablePopup \n";
////		print_r( "filedId $filedId\n" );
//		print_r( "smPropertySection $smPropertySection\n" );
//		print_r( "formattedId $formattedId\n" );
//		print_r( $fieldInfo );
//		echo "</pre>";


		?>
        <div class=" smthemeoptionfield smThemeAddablePopUp">
            <div class="col-md-2">
				<?php echo Form::label( $smPropertySection, $label ); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div id="<?php echo $formattedId; ?>" class="">
                            <!-- Button trigger modal -->
                            <ul class="sortable">
								<?php
								$loop              = 0;
								$newformattedValue = [];
								if ( isset( $fieldInfo["fields"] ) && count( $fieldInfo["fields"] ) > 0 ) {
									if ( is_array( $smPropertyDefault ) && count( $smPropertyDefault ) > 0 ) {
										foreach ( $smPropertyDefault as $single ) {
											?>
                                            <li class="ui-state-default">
                                                <i class="fa fa-sort"></i>
												<?php
												$newSingle = [];

												$title = ( isset( $single[ $fieldInfo["template"] ] ) ) ? $single[ $fieldInfo["template"] ] : "Title";

												$formattedValue = [];
												foreach ( $fieldInfo["fields"] as $singleFiledId => $singleFieldInfo ) {
													$smPropertySectionNew = $smPropertySection . "[$singleFiledId]";

													$selector = str_replace( ']', '_', str_replace( '[', '_', $smPropertySectionNew ) );


													$formattedValue[ $singleFiledId ]["id"]       = $singleFiledId;
													$formattedValue[ $singleFiledId ]["type"]     = $singleFieldInfo['type'];
													$formattedValue[ $singleFiledId ]["name"]     = $smPropertySection;
													$formattedValue[ $singleFiledId ]["selector"] = $selector;
													if ( isset( $single[ $singleFiledId ] ) && is_array( $single[ $singleFiledId ] ) && count( $singleFieldInfo ) > 0 ) {

														foreach ( $single[ $singleFiledId ] as $loop => $single2 ) {
															foreach ( $singleFieldInfo['fields'] as $singleFiledId2 => $singleFieldInfo2 ) {
																$formattedValue[ $singleFiledId ]["value"][ $loop ][ $singleFiledId2 ]["id"]       = $singleFiledId2;
																$formattedValue[ $singleFiledId ]["value"][ $loop ][ $singleFiledId2 ]["type"]     = $singleFieldInfo2['type'];
																$formattedValue[ $singleFiledId ]["value"][ $loop ][ $singleFiledId2 ]["name"]     = $smPropertySectionNew;
																$formattedValue[ $singleFiledId ]["value"][ $loop ][ $singleFiledId2 ]["selector"] = $selector . "_$singleFiledId2";

																$single2 = is_string($single2) ? json_decode($single2, true) : $single2;
//																echo "<pre>";
//																print_r($single2);
//																echo "</pre>";
																$sfv = isset( $single2[ $singleFiledId2 ] ) ? htmlspecialchars( $single2[ $singleFiledId2 ], ENT_QUOTES, 'UTF-8' ) : '';


																$sfv = str_replace( "&quot;", "\"", $sfv );
																$formattedValue[ $singleFiledId ]["value"][ $loop ][ $singleFiledId2 ]["value"] = $sfv;
																$newSingle[ $singleFiledId ][ $loop ][ $singleFiledId2 ]                        = $sfv;
															}
														}
													} elseif ( isset( $single[ $singleFiledId ] ) && $single[ $singleFiledId ] != '' ) {
														$sfv                                       = isset( $single[ $singleFiledId ] ) ? htmlspecialchars( $single[ $singleFiledId ], ENT_QUOTES, 'UTF-8' ) : '';
														$sfv                                       = str_replace( "&quot;", "\"", $sfv );
														$formattedValue[ $singleFiledId ]["value"] = $sfv;
														$newSingle[ $singleFiledId ]               = $sfv;
													} else {
														$formattedValue[ $singleFiledId ]["value"] = "";
														$newSingle[ $singleFiledId ]               = "";
													}
												}
												echo '<span class="sm_theme_popup_title">' . $title . '</span>';
//												echo "<pre>";
//												print_r($newSingle);
//												print_r($formattedValue);
//												echo "</pre>";
												$newSingleJson = json_encode( $newSingle );
												?>
                                                <input type="hidden"
                                                       value='<?php echo $newSingleJson; ?>'
                                                       data-formattedvalue='<?php echo json_encode( $formattedValue ); ?>'
                                                       class="sm_theme_popup_field sm_theme_popup_<?php echo $filedId; ?> <?php echo $formattedId; ?>value"
                                                       data-selector='<?php echo $formattedId; ?>'
                                                       data-info='<?php echo $filedId; ?>'
                                                       name="<?php echo $smPropertySection; ?>[]">

                                                <a href="javascript:void(0)"
                                                   class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"
                                                   data-children="<?php echo $chaildren; ?>"
                                                   data-template="<?php echo $template; ?>"
                                                   data-info='<?php echo $filedId; ?>'
                                                   data-mainid="<?php echo $formattedId; ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </li>
											<?php
											$loop ++;
										}
										?>
										<?php
									}
									foreach ( $fieldInfo["fields"] as $singleFiledId => $singleFieldInfo ) {
										$smPropertySectionNew                            = $smPropertySection . "[$singleFiledId]";
										$newformattedValue[ $singleFiledId ]["id"]       = $singleFiledId;
										$newformattedValue[ $singleFiledId ]["type"]     = $singleFieldInfo['type'];
										$newformattedValue[ $singleFiledId ]["name"]     = $smPropertySectionNew;
										$newformattedValue[ $singleFiledId ]["value"]    = "";
										$newformattedValue[ $singleFiledId ]["selector"] = $formattedId;
									}
								}
								?>


                                <input type="hidden" id="<?php echo $formattedId; ?>_count"
                                       value="<?php echo $loop; ?>">
                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary add_more_popup"
                                id="<?php echo $formattedId; ?>_add_more"
                                data-children="<?php echo $chaildren; ?>"
                                data-template="<?php echo $template; ?>"
                                data-info='<?php echo $filedId; ?>'
                                data-formattedvalue='<?php echo json_encode( $newformattedValue ) ?>'
                                data-target="<?php echo $formattedId; ?>_Modal">
                            <i class="fa fa-plus"></i> <?php echo $add_more_title; ?></button>
                    </div>
                    <div class="col-md-12">
						<?php
						if ( isset( $fieldInfo["desc"] ) && $fieldInfo["desc"] != '' ) {
							?>
                            <p class="sm-theme-hint"><?php echo $fieldInfo["desc"]; ?></p>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <!-- Modal -->
            <div class="modal fade smThemeOptionPopupModal smThemeOptionPopupModal-<?php echo $chaildren; ?>"
                 id="<?php echo $formattedId; ?>_Modal" tabindex="-1"
                 role="dialog" data-backdrop="static" data-keyboard="false"
                 aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close  close_modal"
                                    data-close="<?php echo $formattedId; ?>_Modal"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo $single_title; ?></h4>
                        </div>
                        <div class="modal-body">
							<?php
							if ( isset( $fieldInfo["fields"] ) && count( $fieldInfo["fields"] ) > 0 ) {
								foreach ( $fieldInfo["fields"] as $singleFiledId => $singleFieldInfo ) {
									if ( isset( $singleFieldInfo["extra"]["class"] ) ) {
										$singleFieldInfo["extra"]["class"] = $singleFieldInfo["extra"]["class"] . "sm_theme_popup_field sm_theme_popup_" . $singleFiledId;
									} else {
										$singleFieldInfo["extra"]["class"] = "sm_theme_popup_field sm_theme_popup_" . $singleFiledId;
									}

									$smPropertySectionNew                      = $smPropertySection . "[$singleFiledId]";
									$selector                                  = str_replace( ']', '_', str_replace( '[', '_', $smPropertySectionNew ) );
									$singleFieldInfo["extra"]["data-selector"] = $selector;
									$singleFieldInfo["extra"]["data-info"]     = $singleFiledId;
									$singleFieldInfo["extra"]["data-name"]     = $smPropertySectionNew;
									$default                                   = isset( $singleFieldInfo['default'] ) ? $singleFieldInfo['default'] : null;

									SM::smSwitchToType( $singleFieldInfo, $singleFiledId, $label, $default, $smPropertySection, $isPostOption, $chaildren );
								}
							}
							?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default close_modal"
                                    data-close="<?php echo $formattedId; ?>_Modal">Close
                            </button>
                            <button type="button" class="btn btn-primary save_sm_theme_popup"
                                    data-info=''
                                    data-value=''
                                    data-formattedvalue=''
                                    data-insert="<?php echo $formattedId; ?>"
                                    data-template="<?php echo $template; ?>"
                                    data-children="<?php echo $chaildren; ?>"
                                    data-inputname="<?php echo $smPropertySection; ?>[]"
                            >Save <?php echo $single_title; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                (function ($) {
                    $('#<?php echo $formattedId; ?>_Modal').find('.sm_theme_popup_field').removeAttr('name');
                })(jQuery);
            </script>
            <!-- end Modal -->
            <div class="clearfix"></div>
        </div>
		<?php
	}

}