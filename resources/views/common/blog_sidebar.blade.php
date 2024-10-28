<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/5/17
 * Time: 12:49 PM
 */
?>

<div class="blog-sidebar">
    <aside class="widget">
        <div class="search-widget">
            <form action="{!! url("search") !!}" method="GET">
                <input name="type" type="hidden" value="Blog">
                <input name="s" type="search" placeholder="Search your text here" autocomplete="off" maxlength="100">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </aside>
	<?php
	$blog_popular_is_enable = SM::smGetThemeOption( "blog_popular_is_enable", 1 );
	$blog_show_category = SM::smGetThemeOption( "blog_show_category", 1 );
	$blog_show_tag = SM::smGetThemeOption( "blog_show_tag", 1 );
	$blog_sidebar_add = SM::smGetThemeOption( "blog_sidebar_add", 1 );
	?>
    @if($blog_popular_is_enable==1)
		<?php
		$blog_popular_posts_per_page = SM::smGetThemeOption( "blog_popular_posts_per_page", 5 );
		$popularPosts = SM::getPopularBlog( $blog_popular_posts_per_page );
		?>
        @if(count($popularPosts)>0)
            <aside class="widget">
                <h3 class="widget-title">Popular Post</h3>
                <div class="sidebar-post">
                    @foreach($popularPosts as $blog)
                        <div class="sidebar-post-post">
							<?php
							$blogUrl = url( "blog/$blog->slug" );
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
							?>
                            @empty(!$blog->image)
                                <a href="{!! $blogUrl !!}"> <img
                                            src="{!! SM::sm_get_the_src( $blog->image , 112, 112) !!}"
                                            alt="{{$blog->title}}"></a>
                            @endempty
                            <p class="sp-cat beauty"><i class="fa fa-calendar"></i> <a
                                        href="{!! $blogUrl !!}">{{ date("d, F Y", strtotime($blog->created_at)) }}</a>
                            </p>
                            <h2 class="sp-title"><a href="{!! $blogUrl !!}">{{$blog->title}}</a></h2>
                            <p class="sp-date">
                                <a href="{!! $blogUrl !!}"><i class="fa fa-comments"></i> {{ $commentTitle }}</a>
                                <a href="{!! $blogUrl !!}"><i class="fa fa-eye"></i> {{ $viewsTitle }}</a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </aside>
        @endif
    @endif
    @if($blog_show_category==1)
		<?php
		$getCategories = SM::getCategories(0);
		?>
        @if(count($getCategories)>0)
            <aside class="widget">
                <h3 class="widget-title">Categories</h3>
                <ul>
                    @foreach($getCategories as $cat)
                        <li><a href="{!! url("blog/category/".$cat->slug) !!}">
                                {{$cat->title}} <span>( {{$cat->total_posts}} )</span></a>
                        </li>
                    @endforeach
                </ul>
            </aside>
        @endif
    @endif
    @if($blog_show_tag==1)
		<?php
		$getTags = SM::getTags();
		?>
        @if(count($getTags)>0)
            <aside class="widget">
                <h3 class="widget-title">Tags</h3>
                <div class="tagcloud">
                    @foreach($getTags as $tag)
                        @if($tag->title == ! '')
                            <a href="{!! url("blog/tag/".$tag->slug) !!}">{{$tag->title}}</a>
                        @endif
                    @endforeach
                </div>
            </aside>
        @endif
    @endif
	<?php
	$blog_sidebar_ad_link = SM::smGetThemeOption( "blog_sidebar_ad_link", "#" );
	$blog_sidebar_ad = SM::smGetThemeOption( "blog_sidebar_ad" );
	?>
    @empty(!$blog_sidebar_ad)
        <aside class="widget">
            <div class="adspace">
                <a href="{!! $blog_sidebar_ad_link !!}"><img src="{!! SM::sm_get_the_src( $blog_sidebar_ad ) !!}"
                                                             alt="doodle sidebar"></a>
            </div>
        </aside>
    @endempty
</div>