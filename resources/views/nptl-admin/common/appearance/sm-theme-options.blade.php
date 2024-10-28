@extends('nptl-admin/master')
@section('title',__("menu.themeOption"))
@section('content')
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-sm-theme-options"
                     data-widget-editbutton="false"
                     data-widget-deletebutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
                        <h2>{{__("menu.themeOption")}} </h2>
                        <a class="btn btn-default pull-right"
                           href="{!! url(SM::smAdminSlug("flush-cache")) !!}">
                            <i class="fa fa-trash-o"></i>
                            Flush Cache
                        </a>
                        <button type="button" class="btn btn-default pull-right sm_theme_option_save"
                                id="sm_theme_option_save"><i class="fa fa-save"></i> Save
                        </button>
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
                        <div class="widget-body no-padding smthemeoptions">
                            {!! Form::open(["method"=>"post","route"=>"saveThemeOption", "id"=>"sm_theme_option_form"]) !!}
                            <?php
                            if (isset($smThemeOptions) && is_array($smThemeOptions) && count($smThemeOptions) > 0) {
                                foreach ($smThemeOptions as $sectionId => $sectionValue) {
                                    SM::smSwitchToType($sectionValue, $sectionId);
                                }
                            }
                            ?>
                            <div class="col-sm-12 text-right">
                                <button type="button"
                                        class="btn btn-primary margin-bottom-10  margin-top-10 sm_theme_option_save"
                                        id="sm_theme_option_save"><i class="fa fa-save"></i> Save
                                </button>
                                <a class="btn btn-primary btn-danger"
                                   href="{!! url(SM::smAdminSlug("flush-cache")) !!}">
                                    <i class="fa fa-trash-o"></i>
                                    Flush Cache
                                </a>
                                <button type="button"
                                        class="btn btn-default margin-bottom-10  margin-top-10 sm_theme_option_move_to_top"
                                        id="sm_theme_option_save"><i class="fa fa-arrow-up"></i> Move To Top
                                </button>
                            </div>
                            {!! Form::close() !!}
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
