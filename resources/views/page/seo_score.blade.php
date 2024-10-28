@extends("master")
@section("title", "Seo Score")
@section("content")
    @include("common.seo_form", ["isHome"=>0])
    <!-- REPORT  SEC -->
    <section class="report-sec margin-top60" id="reportSection">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="text-center section-title-4 report-title">
                        <h2>Your Report</h2>
                        <h4 class="web-analyst-title">Website Analyzer</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END  REPORT  SEC -->

    <!-- start WEB SITE ANALYST SEC  -->
    <section class="website-analyst-sec common-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="web-test-skills margin-top20 margin-bottom30" data-parcent="100">
                        <div class="web-seo-test-skillbar clearfix">
                            <h4 class="pull-left">Review of <a href="{!! $seo_url !!}">{{ $seo_url }}</a></h4>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100"
                                 aria-valuemin="0" aria-valuemax="100" style="width:100%">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-level-score">
                        <h3 class="margin-bottom30">PAGE LEVEL SEO SCORE</h3>
                        <ul class="page-level-list clearfix margin-bottom45">
                            <li>
                                <span id="seoScoreLetter">A+
                                    <div class="loader"></div>
                                </span>

                            </li>
                            <li>
                                <span id="errorFound">0</span>
                                Errors
                            </li>
                            <li>
                                <span id="warningFound">0</span>
                                WARNINGS
                            </li>
                            <li>
                                <span id="passedFound">0</span>
                                PASSED
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="#seo-recommendation" class="seo-recomand"> <span
                                        id="seoRecommendationCount">0</span> SEO Recommendations</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="page-level-score">
                        <h3 class="margin-bottom30">PAGE LEVEL SPEED SCORE</h3>
                        <ul class="page-level-list clearfix margin-bottom45">
                            <li>
                                <span id="pageSpeed">
                                        <div class="loader"></div>
                                    0</span>
                            </li>
                            <li>
                                <span id="resources">0</span>
                                Resources
                            </li>
                            <li>
                                <span id="resourcesSize">0</span>
                                Size
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="#seo-analyst" class="seo-recomand"> <span id="speedRecommendationCount">0</span>
                                Speed Recommendation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end WEB SITE ANALYST SEC  -->

    <!-- START PAGE MOCUKP SEC -->
    <section class="Page_Level_Screenshots common-section" id="screenshort">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>Page Level Screenshots</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">

                    <div class="screenshort-tabs-item">
                        <!-- Nav tabs -->
                        <ul class="screenshort-tabs-list screen_tabs_item text-center clearfix margin-bottom45"
                            role="tablist">
                            <li role="presentation" class="active"><a href="#Desktop" aria-controls="Desktop" role="tab"
                                                                      data-toggle="tab"><i class="fa fa-desktop"></i>
                                    Desktop</a></li>
                            <li role="presentation"><a href="#Moblie" aria-controls="Moblie" role="tab"
                                                       data-toggle="tab"><i
                                            class="fa fa-mobile"></i>Moblie view</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="Desktop">
                                <div class="desk-img">
                                    <img src="{!! asset('images/desktop-fram.png') !!}" alt="Doodle Desktop View">
                                    <div class="api-image">
                                        <div class="loader"></div>
                                        <img src="" alt="{{ $seo_url }} desktop view" id="desktopImage">
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="Moblie">
                                <div class="mobile-view">
                                    <img src="" alt="{{ $seo_url }} mobile view" id="mobileImage">
                                    <div class="loader"></div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END PAGE MOCUKP SEC -->

    <!-- START PAGE LAVEL ANALYST SEC -->
    <section class="page-lavel-anylist-score-sec website-analyst-sec common-section" id="page_level_seo_analysis">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>Page Level SEO Analysis</h3>
                        <h3 class="page-scor-title">SCORE: <span id="pageSeoScore">0</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">

                    <div class="screenshort-tabs-item">
                        <!-- Nav tabs -->
                        <ul class="screenshort-tabs-list text-center clearfix margin-bottom45" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#error" aria-controls="error" role="tab" data-toggle="tab"><i
                                            class="fa fa-times-circle-o"></i>
                                    error
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#warning" aria-controls="warning" role="tab" data-toggle="tab"><i
                                            class="fa fa-exclamation-triangle"></i>warning</a>
                            </li>
                            <li role="presentation">
                                <a href="#passed" aria-controls="passed" role="tab" data-toggle="tab"><i
                                            class="fa fa-check-circle"></i>passed</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="error">
                            <div class="error-item text-center margin-bottom45">
                                <h3>Error Test</h3>
                            </div>
                            <ul class="error-list" id="error_list">

                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="warning">
                            <div class="error-item text-center margin-bottom45">
                                <h3>Warning Test</h3>
                            </div>
                            <ul class="error-list warning-list" id="warning_list">

                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="passed">
                            <div class="error-item text-center margin-bottom45">
                                <h3>Passed Tests</h3>
                                <h3>Congratulations the following tests have passed.</h3>
                            </div>
                            <ul class="error-list success-list" id="success_list">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END PAGE LAVEL ANALYST SEC -->

    <!-- START PAGE LAVEL ANALYST SEC -->
    <section class="backlinks-counter common-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="backlink-counter text-center">
                        <h3 class="backlink-title">BACK LINKS COUNTER</h3>
                        <div class="backlink-cont">
                            <h3 id="backlinkcount">0</h3>
                            <h3 id="backlinkLebel">Low</h3>
                        </div>
                        <p>Websites that link back to<a href="{!! $seo_url !!}">{{ $seo_url }}</a></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="backlink-img">
                        <img src="" alt="{{ $seo_url }} desktop view" id="desktopImageBacklink">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="backlink-counter text-center">
                        <h3 class="backlink-title">OF INDEXED PAGES</h3>
                        <div class="indexlink-cont">
                            <h3 id="indexlinkcount">0</h3>
                            <h3 id="indexlinklabel">Low</h3>
                        </div>
                        <p>Pages indexed for<a href="{!! $seo_url !!}">{{ $seo_url }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END PAGE LAVEL ANALYST SEC -->

    <!-- START KEYWORD SEC -->
    <section class="website-analyst-sec keword-sec common-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>Maximum Used Keyword</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="keyword-table table-responsive">
                        <table class="custom-table margin-bottom45" id="mostCommonKeyword">
                            <tr>
                                <th>Serial</th>
                                <th>Keyword</th>
                                <th>Used</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>Most Common Keyword</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="keyword-table table-responsive">
                        <table class="custom-table margin-bottom45" id="keywordUsage">
                            <tr>
                                <th>Serial</th>
                                <th>Keyword</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEC -->

    <!--START SEO RECOMANDATIONS -->
    <section class="page-lavel-anylist-score-sec common-section" id="seo-recommendation">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>Page Level SEO Recommendations</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="screenshort-tabs-item">
                        <!-- Nav tabs -->
                        <ul class="screenshort-tabs-list seo-recomand-list text-center clearfix margin-bottom45"
                            role="tablist">
                            <li role="presentation" class="active">
                                <a href="#High-priority" aria-controls="High-priority" role="tab" data-toggle="tab">
                                    High-priority
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#Medium-priority" aria-controls="Medium-priority" role="tab" data-toggle="tab">Medium-priority</a>
                            </li>
                            <li role="presentation">
                                <a href="#Low-priority" aria-controls="Low-priority" role="tab" data-toggle="tab">
                                    Low priority</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="High-priority">
                            <ul class="page-recomandations-list" id="highPriority">

                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="Medium-priority">
                            <ul class="page-recomandations-list" id="mediumPriority">

                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="Low-priority">
                            <ul class="page-recomandations-list" id="lowPriority">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END SEO RECOMANDATIONS -->

    <!--START SEO RECOMANDATIONS -->
    <section class="seo-analyst website-analyst-sec common-section" id="seo-analyst">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-4 text-center">
                        <h3>Page Level SEO Speed Test</h3>
                        <h3 class="page-scor-title">SCORE: <span id="pageSpeedScore">0</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="screenshort-tabs-item">
                        <!-- Nav tabs -->
                        <ul class="screenshort-tabs-list screen_tabs_item text-center clearfix margin-bottom45"
                            role="tablist">
                            <li role="presentation" class="active">
                                <a href="#Content" aria-controls="Content" role="tab"
                                   data-toggle="tab">
                                    Content Analysis
                                </a></li>
                            <li role="presentation">
                                <a href="#REPORT" aria-controls="REPORT" role="tab"
                                   data-toggle="tab">
                                    FULL REPORT</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="Content">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="single-analyst-item">
                                        <h3 class="margin-bottom45">LOAD TIME ANALYSIS</h3>
                                        <div class="single-analiyst-list-item clearfix" id="load_analysis">
                                            <div class="margin-top-20">
                                                <div class="loader"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="single-analyst-item">
                                        <h3 class="margin-bottom45">SIZE ANALYSIS</h3>
                                        <div class="single-analiyst-list-item clearfix" id="size_analysis">
                                            <div class="margin-top-20">
                                                <div class="loader"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane table-responsive" id="REPORT">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END SEO RECOMANDATIONS -->



    {{--@include("common.seo_form", ["isHome"=>0])--}}
@endsection
@section("footer_script")
	<?php
	SM::smGetSystemFrontEndJs( [
		"https://www.gstatic.com/charts/loader.js",
	], 1 );
	?>
    <script type="text/javascript">
        /**
         * Google page speed insights
         * @author Engr. Mizanur Rahman Khan<engr.mrksohag@gmail.com>
         * @created_at 2017-10-21
         */
        var API_KEY = 'AIzaSyDcAs7Qixs5helFswjG28o9KoOaxPFiKJI';
        var URL_TO_GET_RESULTS_FOR = 'https://getwebinc.com';
        var API_URL = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?';
        var CHART_API_URL = 'http://chart.apis.google.com/chart?';
        var smPageSpeedInsightsCallbacksForDesktop = {};
        var smPageSpeedInsightsCallbacksForMobile = {};
        var seo_url = document.getElementById('seo_url');
        var seo_email = document.getElementById('seo_email');
        var op = document.getElementById('op');
        var seoScore = 0;
        var scoreProgress = 0;
        $('html, body').animate({scrollTop: 650}, "slow");

        function calculateSeoScore() {
//            console.log("seoScore ="+seoScore);
            var seoScoreLetter = "E+";
            if (seoScore <= 45 && seoScore > 30) {
                seoScoreLetter = "D+";
            } else if (seoScore <= 65 && seoScore > 45) {
                seoScoreLetter = "C+";
            } else if (seoScore <= 95 && seoScore > 65) {
                seoScoreLetter = "B+";
            } else if (seoScore > 95) {
                seoScoreLetter = "A+";
            }
            $("#pageSeoScore").text(seoScore);
            $("#seoScoreLetter").html(seoScoreLetter);
            if (scoreProgress > 3) {
                $(".progress-bar").removeClass("active");
                $(".progress-bar").removeClass("progress-bar-striped");
            }
        }

        function smRunPageSpeed(isMobile) {
            var s = document.createElement("script");
            s.type = "text/javascript";
            s.async = true;
            var query = [
                'url=' + URL_TO_GET_RESULTS_FOR,
                'key=' + API_KEY,
                'screenshot=true'
            ].join('&');
            if (isMobile == 1) {
                s.src = API_URL + query + '&callback=smRunPageSpeedCallbacksForMobile&strategy=mobile';
            } else {
                s.src = API_URL + query + '&callback=smRunPageSpeedCallbacksForDesktop';
            }
            document.head.insertBefore(s, null);
        }

        function smRunPageSpeedCallbacksForDesktop(result) {
            scoreProgress++;
            if (result.error) {
                var errors = result.error.errors;
                for (var i = 0, len = errors.length; i < len; ++i) {
                    alert(errors[i].message);
                }
                return;
            }

            for (var fn in smPageSpeedInsightsCallbacksForDesktop) {
                var f = smPageSpeedInsightsCallbacksForDesktop[fn];
                if (typeof f == 'function') {
                    smPageSpeedInsightsCallbacksForDesktop[fn](result);
                }
            }
        }

        function smRunPageSpeedCallbacksForMobile(result) {
            scoreProgress++;
            if (result.error) {
                var errors = result.error.errors;
                for (var i = 0, len = errors.length; i < len; ++i) {
                    alert(errors[i].message);
                }
                return;
            }

            for (var fn in smPageSpeedInsightsCallbacksForMobile) {
                var f = smPageSpeedInsightsCallbacksForMobile[fn];
                if (typeof f == 'function') {
                    smPageSpeedInsightsCallbacksForMobile[fn](result);
                }
            }
//            console.log("score = " + result.score);
//            console.log(result);
        }


        String.prototype.replaceAll = function (search, replacement) {
            var target = this;
            return target.replace(new RegExp(search, 'g'), replacement);
        };

        function isURL(str) {
            var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
            return pattern.test(str);
        }

        document.getElementById('seo_form')
            .addEventListener('submit', function (e) {
                var seo_urlStr = seo_url.value;
                var seoEmail = seo_email.value;
                if (isURL(seo_urlStr)) {
                    URL_TO_GET_RESULTS_FOR = seo_urlStr;
                    processData();
                } else {
                    swal({
                        title: "OOPS!",
                        text: "Please enter a Valid Website Url!",
                        icon: "warning",
                        button: "Aww yes!"
                    });
                    e.preventDefault();
                }
            });

        /**
         * if has seo url
         * @type {string}
         */
        @isset($seo_url)
            seo_url.value = '{{ $seo_url }}';
        seo_email.value = '{{ $email }}';
        URL_TO_GET_RESULTS_FOR = '{{ $seo_url }}';
        processData();

        @endisset

        function processData() {
//            console.log("processData URL_TO_GET_RESULTS_FOR = " + URL_TO_GET_RESULTS_FOR);
            $(function () {
                getSeoInfo(URL_TO_GET_RESULTS_FOR);
                getBackLinkCount(URL_TO_GET_RESULTS_FOR);
            });
            smRunPageSpeed(0);
            smRunPageSpeed(1);
        }

        var data = [['Site Load', 'Hours per Byte']];
        var dataSize = [['Site Load', 'Hours per Byte']];
        var RESOURCE_TYPE_INFO = [
            {label: 'JavaScript', field: 'javascriptResponseBytes', color: 'e2192c'},
            {label: 'Images', field: 'imageResponseBytes', color: 'f3ed4a'},
            {label: 'CSS', field: 'cssResponseBytes', color: 'ff7008'},
            {label: 'HTML', field: 'htmlResponseBytes', color: '43c121'},
            {label: 'Flash', field: 'flashResponseBytes', color: 'f8ce44'},
            {label: 'Text', field: 'textResponseBytes', color: 'ad6bc5'},
            {label: 'Other', field: 'otherResponseBytes', color: '1051e8'},
        ];
        String.prototype.replaceAll = function (search, replacement) {
            var target = this;
            return target.replace(new RegExp(search, 'g'), replacement);
        };
        smPageSpeedInsightsCallbacksForDesktop.displayResourceSizeBreakdown = function (result) {
            data = [['Site Load', 'Hours per Byte']];
            var stats = result.pageStats;
            var resourcesSize = 0;
            for (var i = 0, len = RESOURCE_TYPE_INFO.length; i < len; ++i) {
                var label = RESOURCE_TYPE_INFO[i].label;
                var field = RESOURCE_TYPE_INFO[i].field;
                if (field in stats) {
                    var val = Number(stats[field]);
                    data.push([label, val]);
                    resourcesSize += val;
                    var valInKb = val / 1024;
                    dataSize.push([label + " in KB", valInKb]);
                }
            }
            google.charts.load("current", {packages: ["corechart"]});
            google.charts.setOnLoadCallback(drawChart);

            google.charts.setOnLoadCallback(drawChartSize);

            var speedScore = result.ruleGroups.SPEED.score;
            seoScore += Math.floor((speedScore * 40) / 100);
            calculateSeoScore();
            $("#resourcesSize").html((resourcesSize / 1024 / 1024).toFixed(2) + " MB");
            $("#resources").html(result.pageStats.numberResources);
            $("#pageSpeed").html(speedScore);
            $("#pageSpeedScore").text(speedScore);

            var formattedResults = result.formattedResults.ruleResults;
            $("#REPORT").html("");
            for (var res in formattedResults) {
                var ruleImpact = parseFloat(formattedResults[res].ruleImpact);
                if (ruleImpact > 0) {
                    $("#REPORT").append('<div class="report-scores text-center margin-bottom45">\n' +
                        '<ul>\n' +
                        '<li>\n' + formattedResults[res].localizedRuleName +
                        '<span>(Rule Impact: ' + formattedResults[res].ruleImpact.toFixed(2) +
                        ')</span><br><small>' + formattedResults[res].summary.format +
                        '<small></li>\n' +
                        '</ul>\n' +
                        '</div>');
                    var html = '';
                    var urlBlocks = formattedResults[res].urlBlocks;

                    var speedRecommendationCount = 0;
                    for (var urlsIndex in urlBlocks) {
                        var header = urlBlocks[urlsIndex].header;
                        var url = byte = load = '';
                        for (var argsIndex in header.args) {
                            var args = header.args[argsIndex];
                            if (args.type == 'BYTES') {
                                byte = args.value;
                            } else if (args.type == 'PERCENTAGE') {
                                load = args.value;
                            }
                        }
                        var text = header.format.replaceAll('{', " ");
                        text = text.replaceAll('}', " ");
                        text = text.replaceAll('BEGIN_LINK', "");
                        text = text.replaceAll('END_LINK', "");
                        text = text.replaceAll('SIZE_IN_BYTES', byte);
                        text = text.replaceAll('PERCENTAGE', load);
                        html = '<p>\n' +
                            text +
                            '</p>';


                        if (res == 'EnableGzipCompression' || res == 'MinifyCss' || res == 'MinifyHTML' ||
                            res == 'MinifyJavaScript' || res == 'OptimizeImages') {
                            html += '<table class="custom-table margin-bottom45 report-table table-responsive">\n' +
                                '                                <tbody>\n' +
                                '                                <tr>\n' +
                                '                                    <th>File</th>\n' +
                                '                                    <th>Size</th>\n' +
                                '                                    <th>Reduction</th>\n' +
                                '                                </tr>';
                        } else {
                            html += '<table class="custom-table margin-bottom45 report-table table-responsive">\n' +
                                '                                <tbody>\n' +
                                '                                <tr>\n' +
                                '                                    <th>File</th>\n' +
                                '                                </tr>';
                        }


                        var urls = urlBlocks[urlsIndex].urls;
                        for (var urlIndex in urls) {

                            speedRecommendationCount++;
                            var url = urls[urlIndex];
                            for (var resUrl in url) {
                                var resArgs = url[resUrl].args;
                                var url = byte = load = '';
                                for (var argsIndex in resArgs) {
                                    var args = resArgs[argsIndex];
                                    if (args.type == 'URL') {
                                        url = args.value;
                                    } else if (args.type == 'BYTES') {
                                        byte = args.value;
                                    } else if (args.type == 'PERCENTAGE') {
                                        load = args.value;
                                    }
                                }
                                if (res == 'EnableGzipCompression' || res == 'MinifyCss' || res == 'MinifyHTML' ||
                                    res == 'MinifyJavaScript' || res == 'OptimizeImages') {
                                    html += '<tr>' +
                                        '<td>\n' +
                                        url +
                                        '</td>\n' +
                                        '<td>\n' +
                                        byte +
                                        '</td>\n' +
                                        '<td>\n' +
                                        load +
                                        '</td>' +
                                        '</tr>';
                                } else {
                                    html += '<tr>' +
                                        '<td>\n' +
                                        url +
                                        '</td>\n' +
                                        '</tr>';
                                }
                            }
                        }
                    }


                    html += '</tbody>\n' +
                        '</table>';

                    $("#speedRecommendationCount").text(speedRecommendationCount);
                    $("#REPORT").append(html);
                }
            }
            getImage(['desktopImage', 'desktopImageBacklink'], result.screenshot.data)

        };

        smPageSpeedInsightsCallbacksForMobile.displayResourceSizeBreakdown = function (result) {
            getImage(['mobileImage'], result.screenshot.data);
        };


        function drawChart() {
            var dataChart = google.visualization.arrayToDataTable(data);
            var options = {
//                pieHole: 0.5
                is3D: true,
                width: 450,
                height: 300,
                tooltip: {
                    text: 'percentage'
                }
            };

            var chart1 = document.getElementById('load_analysis');
            chart1.html = "";
            var chart = new google.visualization.PieChart(chart1);
            chart.draw(dataChart, options);
        }

        function drawChartSize() {
            var dataChartSize = google.visualization.arrayToDataTable(dataSize);
            var options = {
//                pieHole: 0.5
                is3D: true,
                pieSliceText: 'value',
                width: 450,
                height: 300,
                tooltip: {
                    text: 'value'
                }
            };

            var chartSize = document.getElementById('size_analysis');
            chartSize.html = "";
            var chart = new google.visualization.PieChart(chartSize);
            chart.draw(dataChartSize, options);
        }

        function getImage(imageId, imageData) {
            var _token = $('#table_csrf_token').val();
            $.ajax({
                type: 'post',
                url: url + 'get-image',
                data: {image_data: imageData, _token: _token},
                success: function (response) {
                    imgBase64 = 'data:image/jpeg;base64,' + response;
                    for (var loop in imageId) {
                        var i = document.getElementById(imageId[loop]);
                        i.src = imgBase64;
                        i.style.display = 'block';
                        $("#" + imageId).siblings(".loader").fadeOut();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function getBackLinkCount(seo_url) {
            var _token = $('#table_csrf_token').val();
            $.ajax({
                type: 'post',
                url: url + 'get-back-link',
                data: {seo_url: seo_url, _token: _token},
                success: function (response) {
                    scoreProgress++;
                    $(".backlink-cont").append('<div class="hidden backlinkResponse">' + response + '</div>');
                    var backLink = parseInt($(".backlink-cont").find(".backlinkResponse").find("#boldResults").text());

                    var backlinkLabel = 'Low';
                    if (!isNaN(backLink)) {
                        $("#backlinkcount").text(backLink);
                        if (backLink > 1000) {
                            backlinkLabel = 'High';
                        }
                    } else {
                        backLink = 0;
                    }
                    var html = '<h3 id="backlinkcount">' + backLink + '</h3>\n' +
                        '                            <h3 id="backlinkLebel">' + backlinkLabel + '</h3>';
                    $(".backlink-cont").html(html);
                    calculateSeoScore();
                }
            });
        }

        function getSeoInfo(seo_url) {
            var _token = $('#table_csrf_token').val();
//            console.log("url " + seo_url + " _token " + _token);
            $.ajax({
                type: 'post',
                url: url + 'seo-info',
                data: {seo_url: seo_url, _token: _token},
                success: function (response) {
                    scoreProgress++;
//                    console.log(response);
                    responseJson = JSON.parse(response);
                    if (responseJson.isAlive == 1) {
                        $('#success_list').html("");
                        var success = Object.keys(responseJson.success).length;
                        if (success > 0) {
                            for (var successData in responseJson.success) {
                                $('#success_list').append(responseJson.success[successData]);
                            }
                        } else {
                            $('#success_list').html('<li>No Success Result Found!</li>');
                        }
                        $("#passedFound").text(success);
                        var warning = Object.keys(responseJson.warning).length;
                        $('#warning_list').html("");
                        if (warning > 0) {
                            for (var warningData in responseJson.warning) {
                                $('#warning_list').append(responseJson.warning[warningData]);
                            }
                        } else {
                            $('#warning_list').html('<li>No Warning Result Found!</li>');
                        }
                        $("#warningFound").text(warning);
                        $('#error_list').html("");
                        var errors = Object.keys(responseJson.errors).length;
                        if (errors > 0) {
                            for (var errorData in responseJson.errors) {
                                $('#error_list').append(responseJson.errors[errorData]);
                            }
                        } else {
                            $('#error_list').html('<li>Congratulations, No Error Found!</li>');
                        }
                        $("#errorFound").text(errors);
                        $("#seoRecommendationCount").text(errors + warning);

                        seoScore += (50 - ((errors + warning) * 5));
                        calculateSeoScore();

                        $('#keywordUsage').html(responseJson.keywordUsage);
                        $('#mostCommonKeyword').html(responseJson.mostCommonKeyword);
                        $('#highPriority').html(responseJson.highPriority);
                        $('#mediumPriority').html(responseJson.mediumPriority);
                        $('#lowPriority').html(responseJson.lowPriority);
                    }
                },
                error: function (error) {
                    $('#success_list').html('<li>' + error.statusText + '</li>');
                    $('#warning_list').html('<li>' + error.statusText + '</li>');
                    $('#error_list').html('<li>' + error.statusText + '</li>');
                    $('#keywordUsage').html('<tr><td colspan="2">' + error.statusText + '</td></tr>');
                    $('#mostCommonKeyword').html('<tr><td colspan="3">' + error.statusText + '</td></tr>');
                    $('#highPriority').html("");
                    $('#mediumPriority').html("");
                    $('#lowPriority').html("");
                }
            });
        }

    </script>
@endsection