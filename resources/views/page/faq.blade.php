@extends("master")
@section("title", "FAQ")
@section("content")
	<?php
	$faq_banner_image = SM::smGetThemeOption( "faq_banner_image" );
	$faq_sections = SM::smGetThemeOption( "faq_sections", [] );
	$faqLoop = 1;
	?>
    <!--BREADCRUMB START-->
    <section class="page-banner-section faq-banner">
        <div class="ab-page-banner-section-inner">
            <img src="{!! SM::sm_get_the_src($faq_banner_image) !!}" alt="FAQ">
        </div>
    </section>
    <!--BREADCRUMB END-->
    @if(count($faq_sections)>0)
        <section class="terms-privacy-policy faq-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        @foreach($faq_sections as $section)
                            <div class="faq-item">
								<?php
								$faq_section_title = isset( $section['faq_section_title'] ) ? $section['faq_section_title'] : null;
								$faqs = isset( $section['faqs'] ) ? $section['faqs'] : [];
								?>
                                @empty(!$faq_section_title)
                                    <h3 class="faq-cat-title">{{ $faq_section_title }}</h3>
                                @endempty
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    @if(count($faqs)>0)
                                        @foreach($faqs as $faqString)
											<?php
											$faq = is_string( $faqString ) ? json_decode( $faqString, true ) : $faqString;
											$faq_title = isset( $faq['faq_title'] ) ? $faq['faq_title'] : "";
											$faq_description = isset( $faq['faq_description'] ) ? $faq['faq_description'] : "";
											?>
                                            <div class="panel panel-default" id="collapse_cat{{ $faqLoop ==1 ? "true" : "false" }}">
                                                <div class="panel-heading" role="tab" id="heading{{ $faqLoop }}">
                                                    <h4 class="panel-title">
                                                        <a class="{{ $faqLoop ==1 ? "" : "collapsed" }}" role="button"
                                                           data-toggle="collapse" data-parent="#accordion"
                                                           href="#collapse{{ $faqLoop }}" aria-expanded="{{ $faqLoop ==1 ? "true" : "false" }}"
                                                           aria-controls="collapse{{ $faqLoop }}">
                                                            <span>Question {{ $loop->iteration }}</span> {{ $faq_title }}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse{{ $faqLoop }}"
                                                     class="panel-collapse collapse {{ $faqLoop ==1 ? "in" : "" }}"
                                                     role="tabpanel"
                                                     aria-labelledby="heading{{ $faqLoop }}">
                                                    <div class="panel-body">
                                                        <div class="tab-content">
                                                            {!! $faq_description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<?php
											$faqLoop ++;
											?>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @include("common.teams", ['class'=>' bg-gray2', 'is_home'=>1])
    @include("common.newslatter")
@endsection
