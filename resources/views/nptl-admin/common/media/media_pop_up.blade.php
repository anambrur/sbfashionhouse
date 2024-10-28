<?php
$files = SM::sm_get_media_files( config( "constant.smPaginationMedia" ) );
?>
<!-- Button trigger modal -->
<div class="modal fade" id="sm_media_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     data-backdrop="static" data-keyboard="false" style="z-index: 9999999">
    <div class="modal-dialog modal-mizan" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} {{__("media.mediaLibrary")}}</h2>
            </div>
            <div class="modal-body">
                <ul id="sm_media_tab" class="nav nav-tabs bordered">
                    <li class="">
                        <a href="#media_library_tab" data-toggle="tab">{{__("media.mediaLibrary")}}</a>
                    </li>
					<?php
					$upload = SM::check_this_method_access( 'media', 'upload' ) ? 1 : 0;
					if ($upload === 1)
					{
					?>
                    <li class="active">
                        <a href="#upload_media_tab" data-toggle="tab">{{__("media.uploadMediaFiles")}}</a>
                    </li>
					<?php
					}
					?>
                </ul>

                <div id="sm_media_tab_content" class="tab-content bge5 padding-10">
                    <div class="tab-pane fade" id="media_library_tab">
                        @include(('nptl-admin/common/media/files'))
                    </div>
					<?php
					if ($upload)
					{
					?>
                    <div class="tab-pane fade in active" id="upload_media_tab">
                        <form action="{{ url(config('constant.smAdminSlug').'/media/upload') }}" class="dropzone"
                              id="mydropzone">
                            <label style="color: #ff0000; font-size: 20px;display: none"><input id="is_private" name="is_private" value="1"
                                                                                  type="checkbox"> Is private file?
                            </label><br>
                            {!! csrf_field() !!}
                        </form>
                    </div>
					<?php
					}
					?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i> Close</span>
                </button>
                <button input_holder="image" img_holder="first_ph" img_width="165" media_width="165" is_multiple="0"
                        type="button" class="btn btn-primary" id="media_insert"><i class="fa fa-plus"></i> Insert
                </button>
            </div>
        </div>
    </div>
</div>