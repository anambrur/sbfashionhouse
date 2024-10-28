@extends(('nptl-admin/master'))
@section('title', 'Admin Dashboard')
@section('subtitle', '')
@section('content')
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-sm-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-visitor" data-widget-editbutton="false">
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
                        <span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
                        <h2>Daily Site Visitor</h2>

                        <ul class="nav nav-tabs pull-right in" id="myTab">
                            <li class="active">
                                <a data-toggle="tab" href="#s1"><i class="fa fa-clock-o"></i>
                                    <span
                                            class="hidden-mobile hidden-tablet">
                                        {{__("dashboard.visitorStats")}}
                                    </span>
                                </a>
                            </li>
                        </ul>

                    </header>

                    <!-- widget div-->
                    <div class="no-padding">
                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                        </div>
                        <!-- end widget edit box -->

                        <div class="widget-body">
                            <!-- content -->
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
                                    <div class="row no-space">
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                            <div id="updating-chart" class="chart-large txt-color-red"></div>

                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text">
                                                        {{__("dashboard.todayVisitor")}} <span
                                                                class="pull-right"><?php
                                                            echo $today_visitor;
                                                            echo $today_visitor == 1 ? ' Person' : ' Persons';
                                                            ?> </span> </span>
                                                    <div class="progress">
                                                        <?php
                                                        if ($max_visitor > 0) {
                                                            $t_slider = ceil((100 * $today_visitor) / $max_visitor);
                                                        } else {
                                                            $t_slider = 0;
                                                        }

                                                        ?>
                                                        <div class="progress-bar bg-color-blueDark"
                                                             style="width: <?php echo "$t_slider"; ?>%;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text">
                                                        {{__("dashboard.maxVisitor")}}
                                                        <span
                                                                class="pull-right"><?php
                                                            echo $max_visitor;
                                                            echo $max_visitor == 1 ? ' Person' : ' Persons';
                                                            ?></span> </span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-color-blue"
                                                             style="width: 100%;"></div>
                                                    </div>
                                                </div>
                                                {{--<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"><span class="text">--}}
                                                {{--{{__("dashboard.bugsSquashed")}}<span--}}
                                                {{--class="pull-right">77%</span> </span>--}}
                                                {{--<div class="progress">--}}
                                                {{--<div class="progress-bar bg-color-blue"--}}
                                                {{--style="width: 77%;"></div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"><span class="text">--}}
                                                {{--{{__("dashboard.userTesting")}} <span--}}
                                                {{--class="pull-right">7 Days</span> </span>--}}
                                                {{--<div class="progress">--}}
                                                {{--<div class="progress-bar bg-color-greenLight"--}}
                                                {{--style="width: 84%;"></div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                            </div>

                                        </div>
                                    </div>


                                </div>
                                <!-- end s1 tab pane -->


                            </div>

                            <!-- end content -->
                        </div>

                    </div>
                    <!-- end widget div -->
                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </div>

        <!-- end row -->

        <!-- row -->

        <div class="row">

            <!-- NEW WIDGET START -->

            <!-- NEW WIDGET START -->
            <article class="col-sm-6">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-customer-info" data-widget-editbutton="false">
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
                        <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                        <h2>Customer Info</h2>
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
                        <div class="widget-body">

                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>customers">
                                            Total Customer
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('users');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>customers">
                                            Approved Customer
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('users', 'status', '1');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>customers">
                                            Pending Customer
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('users', 'status', '2');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>customers">
                                            Cancelled Customer
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('users', 'status', '3');
                                        ?>
                                    </td>
                                </tr>
                            </table>

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
                <div class="jarviswidget" id="wid-admin-info" data-widget-editbutton="false">
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
                        <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                        <h2>Admin Info</h2>
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
                        <div class="widget-body">

                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>users">
                                            Total Admin User
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('admins');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>users">
                                            Approved Customer
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('admins', 'status', '1');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>users">
                                            Pending Admin
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('admins', 'status', '2');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo config('constant.smAdminUrl'); ?>users">
                                            Cancelled Admin
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        echo SM::sm_get_count('admins', 'status', '3');
                                        ?>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->
            <!-- NEW WIDGET START -->

            <!-- WIDGET END -->

        </div>

        <!-- end row -->

    </section>
    <!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
    <script src="{{asset('nptl-admin/js/plugin/flot/jquery.flot.cust.min.js')}}"></script>
    <script src="{{asset('nptl-admin/js/plugin/flot/jquery.flot.resize.min.js')}}"></script>
    <script src="{{asset('nptl-admin/js/plugin/flot/jquery.flot.tooltip.min.js')}}"></script>
    <?php
    $mv = round($max_visitor / 20) * 20;
    $mv = $mv < $max_visitor ? $mv + 20 : $mv;
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var data = [], totalPoints = 200, $UpdatingChartColors = $("#updating-chart").css('color');
            // setup plot
            var options = {
                yaxis: {
                    min: 0,
                    max: <?php echo($mv); ?>
                },
                xaxis: {
                    min: 0,
                    max: 50
                },
                colors: [$UpdatingChartColors],
                series: {
                    lines: {
                        lineWidth: 1,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0
                            }, {
                                opacity: 0.4
                            }]
                        },
                        steps: false
                    }
                },
                grid: {hoverable: true}
            };
            var plot = $.plot($("#updating-chart"), [<?php echo json_encode($viewsReformatted); ?>], options);

            /*end updating chart*/

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 35,
                    left: x - 10,
                    border: '1px solid #fdd',
                    padding: '2px',
                    'background-color': '#fee'
                }).appendTo("body").fadeIn(200);
            }

            var viewsInfo = <?php echo json_encode($viewsInfo); ?>;
            var previousPoint = null;
            $("#updating-chart").bind("plothover", function (event, pos, item) {
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;
                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(0),
                            y = item.datapoint[1].toFixed(0);

                        showTooltip(item.pageX, item.pageY, viewsInfo[x]);
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        });
    </script>
@endsection