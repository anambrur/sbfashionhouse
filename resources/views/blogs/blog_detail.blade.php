@extends("master")
@section("title", $blog->title)
@section("content")
	<?php
	if ( $blog->comments == 1 ) {
		$commentTitle = '1 Comment';
	} elseif ( $blog->comments > 1 ) {
		$commentTitle = $blog->comments . ' Comments';
	} else {
		$commentTitle = 'No Comments';
	}
	if ( $blog->views == 1 ) {
		$viewsTitle = '1 View';
	} elseif ( $blog->views > 1 ) {
		$viewsTitle = $blog->views . ' Views';
	} else {
		$viewsTitle = 'No View';
	}
	if ( $blog->likes == 1 ) {
		$likesTitle = '1 Like';
	} elseif ( $blog->likes > 1 ) {
		$likesTitle = $blog->likes . ' Likes';
	} else {
		$likesTitle = 'No Likes';
	}

	$blogUrl = ( url( "blog/$blog->slug" ) );
	$bannerImage=SM::smGetThemeOption( "blog_detail_banner_image" );
	?>
    <!--BREADCRUMB START-->
    <section class="page-banner-section blog-detail-banner-section">
        <div class="blog-banner-sec "
             style="background:url( {!! SM::sm_get_the_src( $bannerImage ) !!}) no-repeat center center /cover">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="blog-banner-contents text-center">
                        <h1>{{$blog->title}}</h1>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="common-section blog-page-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="single-blog-post-big single-blog-page">
                        @empty(!$blog->image)
                            <div class="blog-img">
                                <img src="{!! SM::sm_get_the_src( $blog->image , 748, 436) !!}"
                                     alt="{{$blog->title}}">
                            </div>
                        @endempty
                        <div class="home-blog-meta">
                            <a href="javascript:0" class="mrks_like"
                               data-id="{{ urlencode(base64_encode($blog->id)) }}"
                               data-type="blog">
                                <i class="fa fa-heart"></i>
                                {{ $likesTitle }}
                            </a>
                            <a href="{{ $blogUrl }}">
                                <i class="fa fa-comments"></i>
                                {{ $commentTitle }}
                            </a>
                            <a href="{{ $blogUrl }}">
                                <i class="fa fa-eye"></i>
                                {{ $viewsTitle }}
                            </a>
                            <div class="b-date">
                                <strong>{{ date("d", strtotime($blog->created_at)) }}</strong>
                                <b>{{ date("F-y", strtotime($blog->created_at)) }}</b>
                            </div>
                        </div>
                        <div class="blog-dec2">
                            <div class=" sm-content">
                                {!! stripslashes($blog->long_description) !!}
                            </div>
                        </div>
                        <div class="single-page-share-opt clearfix">
                            <label class="pull-left">
                                By
								<?php
								$blogAuthor = $blog->user;
								$fname = $blogAuthor->firstname . " " . $blogAuthor->lastname;
								$fname = trim( $fname ) != '' ? $fname : $blogAuthor->username;
								?>
                                {{ $fname }}
                            </label>
                            <div class="socail-share-opt pull-right">
                                <ul>
                                    <li>Share : <i class="fa fa-share-alt"></i></li>
                                    <li>
                                        <a target="_blank"
                                           href="http://www.facebook.com/share.php?u={!! urlencode($blogUrl) !!}&title={!! urlencode($blog->title) !!}">
                                            <i class="fa fa-facebook-square"></i> </a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                           href="http://twitter.com/intent/tweet?status={!! urlencode($blog->title) !!}+{!! urlencode($blogUrl) !!}">
                                            <i class="fa fa-twitter-square"></i> </a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                           href="http://pinterest.com/pin/create/bookmarklet/?url={!! urlencode($blogUrl) !!}&is_video=false&description={!! urlencode($blog->title) !!}">
                                            <i class="fa fa-pinterest-square"></i> </a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                           href="https://plus.google.com/share?url={!! urlencode($blogUrl) !!}">
                                            <i class="fa fa-google-plus-square"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                           href="http://www.linkedin.com/shareArticle?mini=true&url={!! urlencode($blogUrl) !!}&title={!! urlencode($blog->title) !!}">
                                            <i class="fa fa-linkedin-square"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(count($relatedBlog) > 0)
                        <div class="related-blog mb35">
                            <h3 class="com-title pull-left">You May Also like</h3>
                            <div class="releted-blog-dotted pull-right">
                                <div class="tbtn tprev"><i class="fa fa-angle-left"></i></div>
                                <div class="tbtn tnext"><i class="fa fa-angle-right"></i></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="swiper-container releted-blog-slider">
                                    <div class="swiper-wrapper">
                                        @foreach($relatedBlog as $rBlogSingle)
							                <?php
							                $rBlogSingleUrl = url( "blog/$rBlogSingle->slug" );
							                if ( $rBlogSingle->comments == 1 ) {
								                $commentTitle = '1 Comment';
							                } elseif ( $rBlogSingle->comments > 1 ) {
								                $commentTitle = $rBlogSingle->comments . ' Comments';
							                } else {
								                $commentTitle = 'No Comments';
							                }
							                if ( $rBlogSingle->views == 1 ) {
								                $viewsTitle = '1 View';
							                } elseif ( $rBlogSingle->views > 1 ) {
								                $viewsTitle = $rBlogSingle->views . ' Views';
							                } else {
								                $viewsTitle = 'No View';
							                }
							                if ( $rBlogSingle->likes == 1 ) {
								                $likesTitle = '1 Like';
							                } elseif ( $rBlogSingle->likes > 1 ) {
								                $likesTitle = $rBlogSingle->likes . ' Likes';
							                } else {
								                $likesTitle = 'No Likes';
							                }
							                $des = $rBlogSingle->short_description;
							                $des = ( $des != '' ) ? $des : $rBlogSingle->long_description;
							                $sd = strip_tags( stripslashes( $des ), "<br><b>" );
							                $sdSub = substr( $sd, 0, 140 );
							                $sd = ( strlen( $sd ) > 140 ) ? $sdSub . " ....." : $sdSub;
							                ?>
                                            <div class="swiper-slide" data-swiper-autoplay="2500">
                                                <div class="col-sm-12">
                                                    <div class="blog-item">
                                                        <div class="blog-top">
                                                            <div class="blog-img">
                                                                <a href="{!! $rBlogSingleUrl !!}">
                                                                    <img
                                                                            src="{!! SM::sm_get_the_src($rBlogSingle->image, 358, 200) !!}"
                                                                            alt="{{$rBlogSingle->title}}">
                                                                </a>
                                                            </div>
                                                            <div class="home-blog-meta">
                                                                <a href="javascript:0" class="mrks_like"
                                                                   data-id="{{ urlencode(base64_encode($rBlogSingle->id)) }}"
                                                                   data-type="blog">
                                                                    <i class="fa fa-heart"></i>
                                                                    {{ $likesTitle }}
                                                                </a>
                                                                <a href="{{ $rBlogSingleUrl }}">
                                                                    <i class="fa fa-comments"></i>
                                                                    {{ $commentTitle }}
                                                                </a>
                                                                <a href="{{ $rBlogSingleUrl }}">
                                                                    <i class="fa fa-eye"></i>
                                                                    {{ $viewsTitle }}
                                                                </a>
                                                                <div class="b-date">
                                                                    <strong>{{ date("d", strtotime($rBlogSingle->created_at)) }}</strong>
                                                                    <b>{{ date("F-y", strtotime($rBlogSingle->created_at)) }}</b>
                                                                </div>
                                                            </div>
                                                            <h2 class="blog-title">
                                                                <a href="{!! $rBlogSingleUrl !!}">{{$rBlogSingle->title}}</a>
                                                            </h2>
                                                            <p>{{ $sd }}</p>
                                                        </div>
                                                        <div class="blog-author pull-left">
											                <?php
											                $fname = ( trim( $rBlogSingle->fname ) != '' ) ? $rBlogSingle->fname : $rBlogSingle->username;
											                ?>
                                                            <img src="{!! SM::sm_get_the_src($rBlogSingle->author_image, 80, 80) !!}"
                                                                 alt="{{ $fname }}">
                                                            <p>Posted by</p>
                                                            <p class="name">{{ $fname }}</p>
                                                        </div>
                                                        <a href="{!! $rBlogSingleUrl !!}" class="pull-right b_readMore">Read
                                                            More</a>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($blog->comment_enable ==1)
                        <div class="blog-comments-area">
                            <h3 class="com-title">({{$blog->comments}}) COMMENTS</h3>
                            @if(count($commnets) >0)
                                <ol class="comment-list comment-placeholder">
									<?php
									$parentLastCommentId = 0;
									$currentLoadedCommentCount = count( $commnets );
									?>
                                    @foreach($commnets as $comment)
                                        <li>
                                            <div class="single-comment">
                                                <img src="{!! SM::sm_get_the_src(  $comment->user->image , 112, 112) !!}"
                                                     alt="User">
                                                <h3><a href="#">{{ $comment->user->username }}</a></h3>
                                                <div class="con-date">{{date("M d, Y", strtotime($comment->created_at))}}</div>
                                                <a href="javascript:void(0)" class="replay"
                                                   data-comment="{{ $comment->id }}"><i
                                                            class="fa fa-reply"></i>replay</a>
                                                <p>{!! stripslashes($comment->comments) !!}</p>
                                            </div>
											<?php
											SM::getChildrenComment( $blog->id, 1, $comment->id, 1 );
											?>
                                        </li>
										<?php
										$parentLastCommentId = $comment->id;
										?>
                                    @endforeach
                                </ol>
                                @if($commnetsCount>$currentLoadedCommentCount)
                                    <div class="ab-pagination-list text-center">
                                        <a href="javascript:void(0)"
                                           class="loadMoreComments"
                                           id="comments{{$blog->id}}_1_0"
                                           data-url="{{ url('/comments/'.$blog->id.'/1/0/') }}"
                                           data-last="{{ $parentLastCommentId }}"
                                           data-loaded="{{ $currentLoadedCommentCount }}"
                                           data-count="{{ $commnetsCount }}"
                                        ><i class="fa fa-spinner"></i> Load More Comments</a>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-info"><i class="fa fa-info"></i> No comment posted yet!</div>
                            @endif
                        </div>
                    @endif

                    @if($blog->comment_enable ==1)
                        <div class="blog-comments-area">
                            <div class="com-replay-form" id="leaveAComment">
                                <h3 class="com-title">LEAVE A COMMENT</h3>
                                <div class="row  com-form-border">
                                    {!! Form::open(['method'=>"post",'action'=>"Front\Page@saveComment", "id"=>"commentForm"]) !!}
                                    <div class="col-lg-12 doodle-textare-form">
                                        {!! Form::textarea("comments", null, ["placeholder"=>"Write Your Comment...", "id"=>"comments"]) !!}
                                        <span id="commentValidity" class="comments-helper help-block pull-left"
                                              style="display: none">Comment must be between 10 to 500 Characters</span>
                                        <span id="commentLeft" class="comments-helper displayNone help-block pull-right">500 Characters Left</span>
                                    </div>
                                    {{--<div class="col-lg-4">--}}
                                    {{--<input type="text" placeholder="Your Name">--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-4">--}}
                                    {{--<input type="email" placeholder="Your Email">--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-4">--}}
                                    {{--<input type="url" placeholder="Your Website">--}}
                                    {{--</div>--}}
                                    <div class="col-lg-12">
                                        <input type="hidden" value="0" name="parent_id" id="parent_comment_id">
                                        <input type="hidden" value="{{$blog->id}}" name="blog_id" id="">
                                        {{--<button type="submit" >Submit your comment</button>--}}
                                        <input type="submit" id="commentSubmit" value="Submit your comment">
                                    </div>

                                    <div class="col-lg-12" id="commentErrors">
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-sm-4">
                    @include("common.blog_sidebar")
                </div>
            </div>
        </div>
    </section>
    <!--TEAM START-->
    @include("common.teams", ['is_home'=>1,'class'=>'bg-gray2'])
    <!--TEAM END-->
    @include("common.newslatter")
@endsection