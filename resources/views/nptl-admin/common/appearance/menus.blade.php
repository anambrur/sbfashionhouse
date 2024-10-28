@extends("nptl-admin.master")
@section('title','Menus')
@section('content')
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-sm-6">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-list-of-pages-link"
                 data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false"
                 data-widget-fullscreenbutton="false" data-widget-collapsed="false">
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
                    <span class="widget-icon"> <i class="fa fa-pagelines"></i> </span>
                    <h2 class="font-md"><strong>List of Links</strong></h2>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        <div class="col-sm-12 col-lg-12">

                            <div class="row">


                                <div class="panel-group smart-accordion-default" id="accordion-2">



                                    <!---  Page Menu Accordion  -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion-2"
                                                   href="#acc_pages">
                                                    <i class="fa fa-fw fa-plus-circle txt-color-green"></i>
                                                    <i class="fa fa-fw fa-minus-circle txt-color-red"></i>
                                                    Pages </a>
                                            </h4>
                                        </div>
                                        <div id="acc_pages" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div class="smart-form add_custom_menu" id="add_page_div">
                                                    <?php $i = 2; ?>
                                                    @if(isset($pages) && count($pages)>0)
                                                    @foreach($pages as $page)
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkbox"
                                                               value="{{$i}}">
                                                        <i></i>
                                                        <input type="hidden" id="page_checkbox_{{$i}}"
                                                               value="/page/{{ $page->slug }}"
                                                               menu_title="{{$page->menu_title}}"
                                                               menu_type="page">
                                                        {{$page->menu_title}}
                                                    </label>
                                                    <?php $i ++; ?>
                                                    @endforeach

                                                    <div class="clearfix"></div>
                                                    <br>
                                                    @endif
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm btn-primary add_posts_menu_button"><i class="fa fa-plus"></i> Add
                                                        Menu</a>
                                                    <div class="clearfix"></div>
                                                    <br>
                                                </div>

                                            </div>
                                        </div>
                                    </div>



                                             <!---  Package Menu Accordion  -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion-2"
                                                   href="#acc_categories" class="collapsed">
                                                    <i class="fa fa-fw fa-plus-circle txt-color-green"></i>
                                                    <i class="fa fa-fw fa-minus-circle txt-color-red"></i>
                                                    Categories </a>
                                            </h4>
                                        </div>
                                        <div id="acc_categories" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <div class="smart-form add_custom_menu" id="add_package_div">
                                                    @if(isset($categories) && count($categories)>0)
                                                    @foreach($categories as $category)
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkbox"
                                                               value="{{$i}}">
                                                        <i></i>
                                                        <input type="hidden" id="page_checkbox_{{$i}}"
                                                               value="/category/{{$category->slug}}"
                                                               menu_title="{{$category->title}}"
                                                               menu_type="category|{{$category->id}}">
                                                        {{$category->title}}
                                                    </label>
                                                    <?php $i ++; ?>
                                                    @endforeach

                                                    <div class="clearfix"></div>
                                                    <br>
                                                    @endif

                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm btn-primary add_posts_menu_button"><i class="fa fa-plus"></i> Add
                                                        Menu</a>
                                                    <div class="clearfix"></div>
                                                    <br>
                                                </div>

                                            </div>
                                        </div>
                                       
                                    </div>



                                    <!---  Custom Menu Accordion  -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion-2"
                                                   href="#acc_cutom_menu" class="collapsed">
                                                    <i class="fa fa-fw fa-plus-circle txt-color-green"></i>
                                                    <i class="fa fa-fw fa-minus-circle txt-color-red"></i>
                                                    Custom Menu</a>
                                            </h4>
                                        </div>
                                        <div id="acc_cutom_menu" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <div class="smart-form add_custom_menu">
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-navicon" title="Title"></i>
                                                        <input type="text" id="add_custom_menu_title"
                                                               placeholder="Menu title" class="form-control">
                                                    </label>
                                                    <label class="input">
                                                        <i class="icon-prepend fa fa-link" title="URL"></i>
                                                        <input type="text" id="add_custom_menu_link"
                                                               placeholder="Url like http://nextpagetl.com"
                                                               class="form-control">
                                                    </label>
                                                    <div class="clearfix"></div>
                                                    <br>
                                                    <a href="javascript:void(0)" id="add_custom_menu_button"
                                                       class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add
                                                        Menu</a>
                                                    <div class="clearfix"></div>
                                                    <br>
                                                </div>

                                            </div>
                                        </div>


                                    </div>



                                </div>


                            </div>
                        </div>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->


        </article>
        <!-- WIDGET END -->
        <!-- NEW WIDGET START -->
        <article class="col-sm-6">


            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-main_menu" data-widget-editbutton="false"
                 data-widget-colorbutton="false" data-widget-deletebutton="false"
                 data-widget-fullscreenbutton="false">
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
                    <span class="widget-icon"> <i class="fa fa-navicon"></i> </span>
                    <h2 class="font-md"><strong>Main Menu</strong></h2>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="dd ddm" id="nestable_main_menu">
                                    <ol class="dd-list">
                                        <?php
                                        $loop = 0;
                                        if (isset($main_menu['menu_item']) && count($main_menu['menu_item']) > 0) {
                                            $main_menu = $main_menu['menu_item'];
                                            foreach ($main_menu as $item) {
                                                if (isset($item['p_id']) && $item['p_id'] == 0) {
                                                    $loop ++;
                                                    $p_id = isset($item['p_id']) ? $item['p_id'] : 0;
                                                    $menu_type = isset($item['menu_type']) ? $item['menu_type'] : '';
                                                    $title = isset($item['title']) ? $item['title'] : '';
                                                    $link = isset($item['link']) ? $item['link'] : '';
                                                    $cls = isset($item['cls']) ? $item['cls'] : '';
                                                    $link_cls = isset($item['link_cls']) ? $item['link_cls'] : '';
                                                    $icon_cls = isset($item['icon_cls']) ? $item['icon_cls'] : '';
                                                    ?>
                                                    <li class="dd-item li_{{$loop}}" data-id="{{$loop}}">
                                                        <input class="id" value="{{$loop}}" type="hidden"
                                                               name="menu_item[{{$loop}}][id]">
                                                        <input class="p_id" value="{{$p_id}}" type="hidden"
                                                               name="menu_item[{{$loop}}][p_id]">
                                                        <input class="menu_type" value="{{$menu_type}}"
                                                               name="menu_item[{{$loop}}][menu_type]" type="hidden">
                                                        <div class="dd-handle dd3-handle">
                                                            &nbsp;
                                                        </div>
                                                        <div class="dd3-content">
                                                            <span class="menu_content_title_display">{{$title}}</span>
                                                            <span class="pull-right show_menu_content"><i
                                                                    class="fa fa-chevron-down"></i></span>
                                                        </div>
                                                        <div class="menu_content smart-form">
                                                            <label class="input">
                                                                <i class="icon-append fa fa-navicon"
                                                                   title="Add your Title here"></i>
                                                                <input class="form-control menu_content_title title"
                                                                       value="{{$title}}" name="menu_item[{{$loop}}][title]"
                                                                       type="text" placeholder="Menu title">
                                                            </label>
                                                            <label class="input">
                                                                <i class="icon-append fa fa-link"
                                                                   title="Add your Link here"></i>
                                                                <input class="form-control link" value="{{$link}}" type="url"
                                                                       name="menu_item[{{$loop}}][link]"
                                                                       placeholder="Url like http://nextpagetl.com">
                                                            </label>
                                                            <label class="input">
                                                                <i class="icon-append" title="Add your Link Wrapper Class here">Cls</i>
                                                                <input class="form-control cls" value="{{$cls}}" type="text"
                                                                       name="menu_item[{{$loop}}][cls]"
                                                                       placeholder="Add your Link Wrapper class here like home, smddtech">
                                                            </label>
                                                            <label class="input">
                                                                <i class="icon-append" title="Add your Link Class here">Cls</i>
                                                                <input class="form-control link_cls" value="{{$link_cls}}"
                                                                       type="text" name="menu_item[{{$loop}}][link_cls]"
                                                                       placeholder="Add your Link class here like home, smddtech">
                                                            </label>
                                                            <label class="input">
                                                                <i class="icon-append" title="Add your Icon Class here">Cls</i>
                                                                <input class="form-control icon_cls" value="{{$icon_cls}}"
                                                                       type="text" name="menu_item[{{$loop}}][icon_cls]"
                                                                       placeholder="Add your Icon class here like fa fa-plus-square">
                                                            </label>
                                                            <a href="javascript:void(0)"
                                                               class="btn btn-sm btn-danger menu_remove"><i
                                                                    class="fa fa-minus"></i> Remove menu</a>
                                                            <a href="javascript:void(0)"
                                                               class="pull-right btn btn-sm btn-warning menu_cancel"><i
                                                                    class="fa fa-reply"></i> Cancel</a>
                                                        </div>
                                                        <?php
                                                        $child = SM::get_children_menu_backend($main_menu, $item['id'], $loop);
                                                        if ($child['data'] != '') {
                                                            echo "\n\n\n" . '<ol class="dd-list">' . "\n";
                                                            echo $child['data'];
                                                            echo '</ol>' . "\n\n\n";
                                                            $loop = (int) $child['loop'];
                                                        }
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </ol>
                                </div>
                                <input type="hidden" name="menu_item_count" value="{{$loop}}" id="menu_item_count">
                                <div class="clearfix"></div>
                                <br>
                                <a href="<?php echo config('constant.smAdminSlug'); ?>/save_menu" id="save_menu"
                                   class="btn btn-primary"><i class="fa fa-save"></i> Save menu</a>

                            </div>

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