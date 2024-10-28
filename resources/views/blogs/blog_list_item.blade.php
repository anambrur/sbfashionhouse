<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/6/18
 * Time: 9:37 AM
 */
?>
<?php
$blogSecondLoop = 1;
$countBlogPost = count( $blogPost );
?>
@if($countBlogPost > 0)
    @foreach($blogPost as $blog)
        <div class="col-lg-6">
            <div class="blog-item">
                <div class="blog-top">
					<?php
					$sdTitle = strip_tags( stripslashes( $blog->title ), "<br><span><i><b>" );
					$sdSubTitle = substr( $sdTitle, 0, 50 );
					$sdTitle = ( strlen( $sdTitle ) > 50 ) ? $sdSubTitle . " ....." : $sdSubTitle;
					$likeInfo['id'] = $blog->id;
					$likeInfo['type'] = 'blog';

					$blogUrl = url( "blog/" . $blog->slug );
					?>
                    <div class="blog-img">
                        <a href="{!! $blogUrl !!}">
                            <img
                                    src="{!! SM::sm_get_the_src($blog->image, 358, 200) !!}"
                                    alt=" {{ $sdTitle }}">
                        </a>
                    </div>
                    <div class="home-blog-meta">
                        <a href="javascript:0" class="mrks_like"
                           data-id="{{ urlencode(base64_encode($blog->id)) }}"
                           data-type="blog">
                            <i class="fa fa-heart"></i>
                            {{ SM::getCountTitle($blog->likes, 'Like') }}
                        </a>
                        <a href="{{ $blogUrl }}">
                            <i class="fa fa-comments"></i>
                            {{ SM::getCountTitle($blog->comments, 'Comment') }}
                        </a>
                        <a href="{{ $blogUrl }}">
                            <i class="fa fa-eye"></i>
                            {{ SM::getCountTitle($blog->views, 'View') }}
                        </a>
                        <div class="b-date">
                            <strong>{{ date("d", strtotime($blog->created_at)) }}</strong>
                            <b>{{ date("F-y", strtotime($blog->created_at)) }}</b>
                        </div>
                    </div>
                    <h2 class="blog-title"><a
                                href="{!! $blogUrl !!}">
                            {!! $sdTitle  !!}
                        </a>
                    </h2>
					<?php
					$des = $blog->short_description;
					$des = ( $des != '' ) ? $des : $blog->long_description;
					$sd = strip_tags( stripslashes( $des ), "<br><b>" );
					$sdSub = substr( $sd, 0, 125 );
					$sd = ( strlen( $sd ) > 125 ) ? $sdSub . " ....." : $sdSub;
					?>
                    <p>{{ $sd }}</p>
                </div>
                <div class="blog-author pull-left">
                    <img src="{!! SM::sm_get_the_src($blog->user->image, 80, 80) !!}"
                         alt="{{ $blog->user->username }}">
                    <p>Posted by</p>
					<?php
					$fname = $blog->user->firstname . ' ' . $blog->user->lastname;
					$fname = ( $fname != '' ) ? $fname : $blog->user->username;
					?>
                    <p class="name">{{ $fname }}</p>
                </div>
                <a href="{!! $blogUrl !!}" class="pull-right b_readMore">Read
                    More</a>
                <div class="clearfix"></div>
            </div>
        </div>
        @if($loop->iteration %2==0)
            <div class="clearfix"></div>
        @endif
    @endforeach
    <div class="col-lg-12">
        {!! $blogPost->links('common.pagination') !!}
    </div>
@else
    <div class="alert alert-info"><i class="fa fa-info"></i> No Blog Post Found!</div>
@endif
