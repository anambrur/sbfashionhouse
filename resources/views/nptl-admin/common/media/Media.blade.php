@extends(('nptl-admin/master'))
@section('title','Media Library')
@section('content')
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-media_lib" data-widget-editbutton="false">
                    <!-- widget options:
                       usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                       data-widget-colorbutton="false"
                       data-widget-editbutton="false"
                       data-widget-togglebutton="false"
                       data-widget-deletebutton="false"
                       data-widget-fullscreenbutton="false"
                       data-widget-custombutton="false"
                       data-widget-collapsed="true"
                       data-widget-sortable="false"

                    -->
                    <header>
                        <ul id="sm_media_tab" class="nav nav-tabs in">
                            <li class="active">
                                <a href="#media_library_tab" data-toggle="tab">{{__("media.mediaLibrary")}}</a>
                            </li>
							<?php
							$upload = SM::check_this_method_access( 'media', 'upload' ) ? 1 : 0;
							if ($upload === 1)
							{
							?>
                            <li class="">
                                <a href="#upload_media_tab"
                                   data-toggle="tab">{{__("media.uploadMediaFiles")}}</a>
                            </li>
							<?php
							}
							?>
                        </ul>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <div id="sm_media_tab_content" class="tab-content bge5 padding-10">
                                <div class="tab-pane fade in active" id="media_library_tab">
                                    @include(('nptl-admin/common/media/files'))
                                </div>
								<?php
								if ($upload)
								{
								?>
                                <div class="tab-pane fade" id="upload_media_tab">
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
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </div>

        <!-- end row -->

    </section>
@endsection