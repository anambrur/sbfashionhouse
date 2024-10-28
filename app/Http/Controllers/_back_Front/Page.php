<?php
/**
 * All unauthenticated front end properties and methods
 */

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Admin\Common\Blogs;
use App\Mail\ContactMail;
use App\Mail\ServiceMail;
use App\Mail\SubscribeMail;
use App\Model\Common\Blog;
use App\Model\Common\Cases;
use App\Model\Common\Category;
use App\Model\Common\Comment;
use App\Model\Common\Like;
use App\Model\Common\Package;
use App\Model\Common\Package_detail;
use App\Model\Common\Tag;
use App\Rules\SmCustomEmail;
use App\Rules\SmCustomUrl;
use App\SM\SM_Seo_Report;
use Barryvdh\Debugbar\Middleware\Debugbar;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use App\Model\Common\Slider;
use Auth;
use App\Model\Common\Subscriber;
use App\Model\Common\Page as Page_model;
use App\Model\Common\Media;
use cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use URL;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Model\Common\Service;

/**
 * Front end unauthenticated methods and properties
 * Class Page
 * @package App\Http\Controllers\Front
 */
class Page extends Controller {

	public function __construct() {
	}

	/**
	 * Home page methods and return view
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		$data = $this->homePageData();

		return view( "Home", $data );
	}

	/**
	 * Home page all data, it call from index of page, login and registration.
	 * @return array
	 */
	public function homePageData() {
		$data["title"]   = "Home";
		$data["is_home"] = 1;
		$key             = 'homeContent';
		$data["sliders"] = SM::getCache( 'homeSlider', function () {
			return Slider::where( "status", 1 )->get();
		} );

		$data["cases"]       = SM::getCache( 'homeCases', function () {
			$case_show = SM::smGetThemeOption( "case_show", 3 );

			return Cases::where( "status", 1 )
			            ->orderBy( "id", "desc" )
			            ->limit( $case_show )
			            ->get();
		} );
		$data["blogs"]       = SM::getCache( 'homeBlogs', function () {
			$blog_show = SM::smGetThemeOption( "blog_show", 6 );

			return Blog::with( "user" )
			           ->where( "status", 1 )
			           ->orderBy( "id", "desc" )
			           ->limit( $blog_show )
			           ->get();
		} );
		$data['homeContent'] = \View::make( 'partials.home', $data )->render();

		return $data;
	}


	/**
	 * Check customer logged in or not
	 * @return integer 0=False or 1=true
	 */
	public function isCustomerLoggedIn() {
		if ( Auth::check() ) {
			return response( 1 );
		} else if ( Session::has( "guest" ) ) {
			return response( 1 );
		} else {
			if ( isset( $_GET['href'] ) ) {
				$url = $_GET['href'];
				if ( strpos( $url, url( "" ) ) !== false ) {
					Session::put( "smPackageUrl", $url );
					Session::save();
				}
			}

			return response( 0 );
		}
	}

	/**
	 * All dynamic created page will show from here
	 *
	 * @param $url page url
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
	 */
	function page( $url ) {
		$data['page'] = SM::getCache( 'page_' . $url, function () use ( $url ) {
			return Page_model::where( 'slug', $url )->where( 'status', 1 )->first();
		} );
		if ( isset( $data['page']->id ) ) {
			$data['smAdminBarId'] = $data["page"]->id;
			//view increment
			$data['page']->increment( 'views' );
			//seo data
			$data['meta_key']         = $data['page']->meta_key;
			$data['meta_description'] = $data['page']->meta_description;
			$data['sidebar']          = 1;

			return view( 'Page', $data );
		} else {
			return abort( 404 );
		}
	}

	/**
	 * Category page display by category slug
	 *
	 * @param $slug string
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
	 */
	public function category( $slug ) {
		$data["categoryInfo"] = SM::getCache( 'category_' . $slug, function () use ( $slug ) {
			return Category::with( "blogs" )
			               ->where( "slug", $slug )
			               ->where( 'status', 1 )
			               ->first();
		} );
		if ( count( $data["categoryInfo"] ) > 0 ) {
			$page                     = \request()->input( 'page', 0 );
			$key                      = 'categoryBlogs_' . $data["categoryInfo"]->id . '_' . $page;
			$data["blogs"]            = SM::getCache(
				$key, function () use ( $data ) {
				$blog_posts_per_page = SM::smGetThemeOption(
					"blog_posts_per_page",
					config( "constant.smFrontPagination" )
				);

				return $data["categoryInfo"]->blogs()
				                            ->where( "status", 1 )
				                            ->paginate( $blog_posts_per_page );
			}, [ 'categoryBlogs' ]
			);
			$data['seo_title']        = $data['categoryInfo']->seo_title;
			$data["meta_key"]         = $data["categoryInfo"]->meta_key;
			$data["meta_description"] = $data["categoryInfo"]->meta_description;
			$data["image"]            = $data["categoryInfo"]->image != '' ? asset( SM::sm_get_the_src( $data["categoryInfo"]->image, 750, 560 ) ) : '';

			return view( 'page.category', $data );
		} else {
			return abort( 404 );
		}
	}


	/**
	 * Tag page info by tag slug
	 *
	 * @param $slug string
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
	 */
	public function tag( $slug ) {
		$data["tagInfo"] = SM::getCache( 'tag_' . $slug, function () use ( $slug ) {
			return Tag::with( "blogs" )
			          ->where( "slug", $slug )
			          ->where( 'status', 1 )
			          ->first();
		} );
		if ( count( $data["tagInfo"] ) > 0 ) {
			$page                     = \request()->input( 'page', 0 );
			$key                      = 'tagBlogs_' . $data["tagInfo"]->id . '_' . $page;
			$data["blogs"]            = SM::getCache( $key, function () use ( $data ) {

				$blog_posts_per_page = SM::smGetThemeOption(
					"blog_posts_per_page",
					config( "constant.smFrontPagination" )
				);

				return $data["tagInfo"]->blogs()
				                       ->where( "status", 1 )
				                       ->paginate( $blog_posts_per_page );
			}, [ 'tagBlogs' ] );
			$data['key']              = $key;
			$data['seo_title']        = $data['tagInfo']->seo_title;
			$data["meta_key"]         = $data["tagInfo"]->meta_key;
			$data["meta_description"] = $data["tagInfo"]->meta_description;
			$data["image"]            = $data["tagInfo"]->image != '' ? asset( SM::sm_get_the_src( $data["tagInfo"]->image, 750, 560 ) ) : '';

			return view( 'page.tag', $data );
		} else {
			return abort( 404 );
		}
	}

	/**
	 * Blog listing page show
	 * @return view
	 */
	public function blog( $slug = null ) {
		if ( $slug != null ) {
			return $this->blogDetail( $slug );
		}
		$page = \request()->input( 'page', 0 );
		$key  = 'blogs_page_' . $page;

		$data["blogPost"] = SM::getCache( $key, function () {
			$blog_posts_per_page = SM::smGetThemeOption(
				"blog_posts_per_page",
				config( "constant.smFrontPagination"
				) );

			return Blog::with( 'user' )
			           ->where( "is_sticky", 0 )
			           ->where( "status", 1 )
			           ->orderBy( "id", "desc" )
			           ->paginate( $blog_posts_per_page );
		}, [ 'blogs' ] );

		if ( \request()->ajax() ) {
			$html = view( "blogs/blog_list_item", $data )->render();

			return response( $html );
		} else {
			$data["stickyBlogPost"] = SM::getCache( 'stickyBlogs', function () {
				return Blog::where( "is_sticky", 1 )
				           ->where( "status", 1 )
				           ->orderBy( "id", "desc" )
				           ->limit( 9 )
				           ->get();
			} );

			$data['seo_title']        = SM::smGetThemeOption( "blog_seo_title" );
			$data['meta_description'] = SM::smGetThemeOption( "blog_meta_keywords" );
			$data['meta_description'] = SM::smGetThemeOption( "blog_meta_description" );

			return view( "blogs/blog", $data );
		}
	}

	/**
	 * Blog detail page show by slug
	 *
	 * @param $slug string
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
	 */
	public function blogDetail( $slug ) {
		$data["blog"] = SM::getCache( 'blog_' . $slug, function () use ( $slug ) {
			return Blog::with( "categories", "user" )
			           ->where( "slug", $slug )
			           ->where( "status", 1 )
			           ->first();
		} );
		if ( count( $data["blog"] ) > 0 ) {
			$data['smAdminBarId'] = $data["blog"]->id;

			$data["blog"]->increment( "views" );

			$data["relatedBlog"] = SM::getCache( 'blog_related_blog_' . $slug, function () use ( $data ) {
				$blog_related_posts_per_page = SM::smGetThemeOption( "blog_related_posts_per_page", 2 );
				$cats                        = SM::get_ids_from_data( $data['blog']->categories );

				return DB::table( "blogs" )
				         ->select( 'blogs.*', DB::raw( "CONCAT(firstname, ' ', lastname) as fname" ),
					         'users.username', 'users.image as author_image' )
				         ->join( "categoryables", function ( $join ) {
					         $join->on( "categoryables.categoryable_id", "=", "blogs.id" )
					              ->where( "categoryables.categoryable_type", '=', 'App\Model\Common\Blog' );
				         } )
				         ->join( "users", 'blogs.created_by', '=', 'users.id' )
				         ->whereIn( "categoryables.category_id", $cats )
				         ->where( "blogs.id", '!=', $data["blog"]->id )
				         ->where( "blogs.status", 1 )
				         ->orderBy( "blogs.id", "desc" )
				         ->limit( $blog_related_posts_per_page )
				         ->get();
			} );
			/**
			 * If related blog not found then show post from all post
			 */
			if ( count( $data["relatedBlog"] ) < 1 ) {
				$data["relatedBlog"] = SM::getCache( 'blog_related_all_blog_' . $slug, function () use ( $data ) {
					$blog_related_posts_per_page = SM::smGetThemeOption( "blog_related_posts_per_page", 2 );

					return DB::table( "blogs" )
					         ->select( 'blogs.*', DB::raw( "CONCAT(firstname, ' ', lastname) as fname" ),
						         'users.username', 'users.image as author_image' )
					         ->join( "users", 'blogs.created_by', '=', 'users.id' )
					         ->where( "blogs.id", '!=', $data["blog"]->id )
					         ->where( "blogs.status", 1 )
					         ->orderBy( "blogs.id", "desc" )
					         ->limit( $blog_related_posts_per_page )
					         ->get();
				} );
			}
			$data["commnetsCount"]    = SM::getCache( 'blog_comments_0_count_' . $slug, function () use ( $data ) {
				return Comment::where( "commentable_id", $data["blog"]->id )
				              ->where( "commentable_type", 'App\Model\Common\Blog' )
				              ->where( "p_c_id", 0 )
				              ->where( "status", 1 )
				              ->count();
			}, [ 'blog_comments_count_' . $slug ] );
			$blogId                   = $data["blog"]->id;
			$data["commnets"]         = SM::getCache( 'blog_comments_0_0_' . $blogId, function () use ( $data ) {
				return SM::getCommentList( $data["blog"]->id, 'App\Model\Common\Blog', 0, 0 );
			}, [ 'blog_comments_' . $blogId ] );
			$data['seo_title']        = $data['blog']->seo_title;
			$data["meta_key"]         = $data["blog"]->meta_key;
			$data["meta_description"] = $data["blog"]->meta_description;
			$data["image"]            = asset( SM::sm_get_the_src( $data["blog"]->image, 750, 560 ) );

			return view( "blogs/blog_detail", $data );
		} else {
			return abort( 404 );
		}
	}


	/**
	 * get comments by required info
	 *
	 * @param integer $blogId blog id
	 * @param integer $type type of comment like blog, service
	 * @param integer $parentId parent id
	 * @param integer $parentLastCommentId parent last post id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAjaxComments( $blogId, $type, $parentId, $parentLastCommentId ) {
		$typeStr               = SM::getCommentableTypeByFixedId( $type );
		$key                   = 'blog_comments_' . $parentId . '_' . $parentLastCommentId . '_' . $blogId;
		$commnets              = SM::getCache( $key, function ()
		use ( $blogId, $typeStr, $parentId, $parentLastCommentId ) {
			return SM::getCommentList( $blogId, $typeStr, $parentId, $parentLastCommentId );
		}, [ 'blog_comments_' . $blogId ] );
		$data['commnetsCount'] = count( $commnets );
		$data['html']          = '';
		if ( count( $commnets ) > 0 ) {
			ob_start();
			$parentLastCommentId       = 0;
			$currentLoadedCommentCount = count( $commnets );
			foreach ( $commnets as $comment ) {
				?>
                <li>
                    <div class="single-comment">
                        <img src="<?= SM::sm_get_the_src( $comment->user->image, 112, 112 ); ?>"
                             alt="<?= $comment->user->username ?>">
                        <h3><a href="#"><?= $comment->user->username ?></a></h3>
                        <div class="con-date"><?= date( "M d, Y", strtotime( $comment->created_at ) ) ?></div>
                        <a href="javascript:void(0)" class="replay"
                           data-comment="<?= $comment->id ?>"><i
                                    class="fa fa-reply"></i>replay</a>
                        <p><?= stripslashes( $comment->comments ); ?></p>
                    </div>
					<?php
					SM::getChildrenComment( $blogId, $type, $comment->id, 1 );
					?>
                </li>
				<?php
				$parentLastCommentId = $comment->id;
			}
			$data['last'] = $parentLastCommentId;
			$data['html'] = ob_get_clean();
		}

		return response()->json( $data, 200 );
	}

	/**
	 * Save comment info
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function saveComment( Request $request ) {
		if ( Auth::check() ) {
			$messages = [
				'unique' => 'Comment must be unique. Don\'t spamming please.',
			];
			$this->validate( $request, [
				'comments'  => "required|min:10|max:500|unique:comments",
				'blog_id'   => "required|integer",
				'parent_id' => "required|integer",
			], $messages );

			$blog = Blog::find( $request->blog_id );
			if ( count( $blog ) > 0 ) {
				$comment                   = new Comment();
				$comment->commentable_id   = $blog->id;
				$comment->commentable_type = 'App\Model\Common\Blog';
				$comment->p_c_id           = $request->parent_id;
				$comment->comments         = strip_tags( $request->comments );
				$comment->created_by       = Auth::user()->id;
				$comment->status           = 2;
				$comment->save();

				return response( "Blog comment saved successfully! Please wait for approve.", 200 );
			} else {
				return response( "Blog Not Found!", 404 );
			}
		} else {
			response( "Please login to submit a comment!", 404 );
		}
	}

	/**
	 * Show service list page
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
	 */
	public function services( $slug = null ) {
		if ( $slug != null ) {
			return $this->serviceDetail( $slug );
		}
		$page             = \request()->input( 'page', 0 );
		$data["services"] = SM::getCache( 'services' . $page, function () {
			$services_posts_per_page = SM::smGetThemeOption(
				"services_posts_per_page",
				config( "constant.smFrontPagination" )
			);

			return Service::where( "status", 1 )
			              ->paginate( $services_posts_per_page );
		}, [ 'service' ] );
		if ( \request()->ajax() ) {
			$html = view( 'services.service_list_item', $data )
				->render();

			return response( $html );
		}

		$data['seo_title']        = SM::smGetThemeOption( "services_seo_title" );
		$data['meta_description'] = SM::smGetThemeOption( "services_meta_keywords" );
		$data['meta_description'] = SM::smGetThemeOption( "services_meta_description" );

		return view( "services.services", $data );
	}


	/**
	 * Show service detail page by service slug
	 *
	 * @param $slug string
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
	 */
	public function serviceDetail( $slug ) {
		$data["serviceInfo"] = SM::getCache( 'service_' . $slug, function () use ( $slug ) {
			return Service::where( "slug", $slug )
			              ->where( 'status', 1 )
			              ->first();
		} );
		if ( count( $data["serviceInfo"] ) > 0 ) {
			$data['smAdminBarId'] = $data["serviceInfo"]->id;
			//seo data
			$data['seo_title']        = $data['serviceInfo']->seo_title;
			$data['meta_key']         = $data['serviceInfo']->meta_key;
			$data['meta_description'] = $data['serviceInfo']->meta_description;
			$data["image"]            = asset( SM::sm_get_the_src( $data["serviceInfo"]->image, 750, 560 ) );

			return view( "services.service_detail", $data );
		} else {
			return abort( 404 );
		}

	}


	/**
	 * Send service meail from service detail page
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function serviceMail( Request $request ) {
		$this->validate( $request, [
			'service_id' => 'required|integer',
			'service'    => 'required',
			'full_name'  => 'required',
			'email'      => 'required|email',
			'phone'      => 'required',
		] );
		$mailto = SM::sm_get_site_email();
		Mail::to( $mailto )
		    ->queue( new ServiceMail( (object) $request->all() ) );

		$data['is_success'] = 1;
		$data['mailto']     = $mailto;
		$data['message']    = "Service Mail Successfully Sent";

		return response()->json( $data );
	}

	/**
	 * Subscribe information
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function subscribe( Request $request ) {
		$this->validate( $request, [ 'email' => 'required|email' ] );

		$infos        = new \stdClass();
		$infos->email = $request->email;
		$infos->ip    = $request->ip();

		$loc              = file_get_contents( 'https://ipapi.co/' . $request->ip() . '/json' );
		$locInfo          = json_decode( $loc );
		$infos->city      = isset( $locInfo->city ) ? $locInfo->city : "";
		$infos->state     = isset( $locInfo->region ) ? $locInfo->region : "";
		$infos->country   = isset( $locInfo->country_name ) ? $locInfo->country_name : "";
		$subscribeMessage = SM::subscribe( $infos, 0);

		$sInfo                        = $request->all();
		$sInfo['isAlreadySubscribed'] = $subscribeMessage['isAlreadySubscribed'];
		Mail::to( $request->email )
		    ->queue( new SubscribeMail( (object) $sInfo ) );
            return back()->with('s_message', "Thank You For Subscribing!. You're just one step away from being one of our dear susbcribers.Please check the Email provided and confirm your susbcription!");
//		return response( $subscribeMessage, 200 )
//			->cookie( 'doodleSubscriber', $infos->email, config( 'constant.popupHideTimeInMinutesForSubscriber' ) );
	}

	/**
	 * subscribeConfirmation
	 *
	 * @param $email
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function subscribeConfirmation( $email ) {
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			return redirect( '/' )->with( 'w_message', 'Invalid Email' );
		} else {
			$subscriber = Subscriber::where( "email", $email )->first();
			if ( $subscriber ) {
				$subscriber->status = 1;
				$subscriber->update();

				return view( "page.subscription-confirmation" );
			} else {
				return redirect( '/' )->with( 'w_message', 'No Subscriber Found' );
			}
		}
	}

	/**
	 * Subscription closing after a cancel button press
	 * @return integer
	 */
	public function subscriptionClosedForADay() {
		return response( 1, 200 )
			->cookie( 'doodleSubscriber', "mrksohag", config( 'constant.popupHideTimeInMinutes' ) );
	}

	/**
	 * Offer close after offer cancel button press
	 * @return integer
	 */
	public function offerClosedForADay() {
		return response( 1, 200 )
			->cookie( 'doodleOffer', "mrksohag", config( 'constant.popupHideTimeInMinutes' ) );
	}


	/**
	 * Unsubscribe subscribed user
	 *
	 * @param $email
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function unsubscribe( $email ) {
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			return redirect( '/' )->with( 'w_message', 'Invalid Email' );
		} else {
			$subscriber = Subscriber::where( "email", $email )->first();
			if ( $subscriber ) {
				$subscriber->status = 0;
				if ( $subscriber->update() > 0 ) {
					return redirect( '/' )->with( 's_message', 'Successfully Unsubscribed' );
				} else {
					return redirect( '/' )->with( 'w_message', 'Unsubscriber Failed! Please contact to Admin.' );
				}
			} else {
				return redirect( '/' )->with( 'w_message', 'No Subscriber Found' );
			}
		}
	}


	/**
	 * Contact page show
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function contact() {
		$data['seo_title']        = SM::smGetThemeOption( "contact_seo_title" );
		$data['meta_description'] = SM::smGetThemeOption( "contact_meta_keywords" );
		$data['meta_description'] = SM::smGetThemeOption( "contact_meta_description" );

		return view( "page.contact", $data );
	}


	/**
	 * Contact page Send mail
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function send_mail( Request $request ) {
		$this->validate( $request, [
			"fullname" => "required|min:3|max:40",
			"email"    => [ "required", new SmCustomEmail ],
			"subject"  => "required|min:3|max:100",
			"message"  => "required|min:5|max:500"
		] );
		Mail::to( SM::get_setting_value( "email" ) )
		    ->queue( new ContactMail( (object) $request->all() ) );
		$contact_form_success_message = SM::smGetThemeOption(
			"contact_form_success_message", "Mail successfully send. We will contact you as soon as possible."
		);

		return response( $contact_form_success_message, 200 );
	}


	/**
	 * Show about page
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function about() {
		$data['seo_title']        = SM::smGetThemeOption( "about_seo_title" );
		$data['meta_description'] = SM::smGetThemeOption( "about_meta_keywords" );
		$data['meta_description'] = SM::smGetThemeOption( "about_meta_description" );

		return view( "page.about", $data );
	}

	/**
	 * Show faq page
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function faq() {
		$data['seo_title']        = SM::smGetThemeOption( "faq_seo_title" );
		$data['meta_description'] = SM::smGetThemeOption( "faq_meta_keywords" );
		$data['meta_description'] = SM::smGetThemeOption( "faq_meta_description" );

		return view( "page.faq", $data );
	}


	/**
	 * Show Team page
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function team() {
		$data['seo_title']        = SM::smGetThemeOption( "team_seo_title" );
		$data['meta_description'] = SM::smGetThemeOption( "team_meta_keywords" );
		$data['meta_description'] = SM::smGetThemeOption( "team_meta_description" );

		return view( "page.teams", $data );
	}


	/**
	 * Show case list page
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function caseList( $slug = null ) {
		if ( $slug != null ) {
			return $this->caseDetail( $slug );
		}
		$page               = \request()->input( 'page', 0 );
		$data["cases"]      = SM::getCache( 'case' . $page, function () {
			$case_posts_per_page = SM::smGetThemeOption(
				"case_posts_per_page",
				12
			);

			return Cases::with( "categories", "tags" )
			            ->where( "status", 1 )
			            ->paginate( $case_posts_per_page );
		}, [ 'case' ] );
		$data["categories"] = [];
		if ( count( $data["cases"] ) > 0 ) {
			foreach ( $data["cases"] as $case ) {
				if ( isset( $case->categories ) && count( $case->categories ) > 0 ) {
					foreach ( $case->categories as $cat ) {
						$data["categories"][ $cat->id ] = $cat->title;
					}
				}
			}
		}

		$data['seo_title']        = SM::smGetThemeOption( "case_seo_title" );
		$data['meta_description'] = SM::smGetThemeOption( "case_meta_keywords" );
		$data['meta_description'] = SM::smGetThemeOption( "case_meta_description" );

		return view( "page.case_list", $data );
	}


	/**
	 * Show case detail page by case slug
	 *
	 * @param $slug string
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
	 */
	public function caseDetail( $slug ) {
		$data["caseInfo"] = SM::getCache( 'case_' . $slug, function () use ( $slug ) {
			return Cases::where( "slug", $slug )
			            ->where( 'status', 1 )
			            ->first();
		} );
		if ( count( $data["caseInfo"] ) > 0 ) {
			$data['smAdminBarId'] = $data["caseInfo"]->id;
			$data["caseInfo"]->increment( "views" );
			//seo data
			$data['seo_title']        = $data['caseInfo']->seo_title;
			$data['meta_key']         = $data['caseInfo']->meta_key;
			$data['meta_description'] = $data['caseInfo']->meta_description;
			$img                      = $data['caseInfo']->image;
			if ( ! $image_array = explode( ',', $img ) ) {
				$image_array[0] = array( $img );
			}
			$data["image"] = asset( SM::sm_get_the_src( $image_array[0], 750, 560 ) );

			return view( "page.case_detail", $data );
		} else {
			return abort( 404 );
		}

	}

	/**
	 * Show seo score by url and end email
	 *
	 * @param Request $request
	 *
	 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function seoScore( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'seo_url' => 'required|url',
			'email'   => 'required|email',
		] );
		$seoUrl    = $data["seo_url"] = $request->input( "seo_url" );
		$seoEmail  = $data["email"] = $request->input( "email" );
		$seoUrl    = rtrim( $seoUrl, '/\\' );

		//subscribe
		$infos            = new \stdClass();
		$infos->email     = $seoEmail;
		$subscribeMessage = SM::subscribe( $infos );

		$data["mobile"]  = new \stdClass();
		$data["desktop"] = new \stdClass();


//		echo "<pre>";
		$cacheDesktop = "smDesktop" . $seoUrl;
		$cacheMobile  = "smMobile" . $seoUrl;
		if ( $validator->fails() ) {
			$previousUrl = URL::previous();
			$previousUrl = str_replace( '?isSeoScoreError=1', '', $previousUrl );

			return redirect( $previousUrl . "?isSeoScoreError=1" )->withErrors( $validator )->withInput();
		}

		return view( 'page.seo_score', $data );
	}

	/**
	 * Get backlink info from searchenginegenie.com site.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function getBackLink( Request $request ) {
		$this->validate( $request, [
			'seo_url' => 'required'
		] );
		$base_url = 'https://www.searchenginegenie.com/tools/includes/backlinks-google.php';

		$fields_str = "content=" . SM::removeHttp( $request->seo_url ) . "&type=GoogleBackLinks&code=10&comp=MTA=";

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $base_url );
		curl_setopt( $ch, CURLOPT_POST, 4 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_str );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return response( $result, 200 );
	}

	/**
	 * Get meta html info for seo score page
	 *
	 * @param Request $request
	 */

	public function getHtmlMetaInfo( Request $request ) {
		$this->validate( $request, [
			'seo_url' => 'required'
		] );
		$url    = $request->seo_url;
		$url    = rtrim( $url, '/\\' );
		$report = new SM_Seo_Report( $url );
		echo json_encode( $report->getSeoReport() );
		exit;
	}


	/**
	 * Google provided base64 encoded image  modify
	 *
	 * @param Request $request
	 */
	public function getBase64Image( Request $request ) {
		$this->validate( $request, [
			'image_data' => 'required'
		] );
		$image = str_replace( '_', '/', $request->image_data );

		echo str_replace( '-', '+', $image );
		exit;
	}


	/**
	 * Show search information
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function search( Request $request ) {
		if ( $request->method() == 'POST' ) {
			$this->validate( $request, [
				'search_type' => 'required',
				'search_text' => 'required'
			] );
			$search_type = $request->input( 'search_type' );
			$search_text = $request->input( 'search_text' );
			$list        = '';
			if ( $search_type == 'Package' ) {
				$list .= $this->getPackageSearchData( $search_text );
			} else if ( $search_type == 'Blog' ) {
				$list .= $this->getBlogSearchData( $search_text );
			} else if ( $search_type == 'Case' ) {
				$list .= $this->getCaseSearchData( $search_text );
			} else if ( $search_type == 'Service' ) {
				$list .= $this->getServiceSearchData( $search_text );
			} else {
				$list .= $this->getBlogSearchData( $search_text );
				$list .= $this->getCaseSearchData( $search_text );
				$list .= $this->getServiceSearchData( $search_text );
			}
			echo $list;
			exit();
		} else {
			$search_type     = $data["type"] = $request->input( 'type', "Package" );
			$search_text     = $data["s"] = $request->input( 's', "" );
			$data["results"] = array();
			if ( trim( $search_text ) != '' ) {
				if ( $search_type == 'Package' ) {
					$data["results"] = $this->getPackageSearchData( $search_text, false );
				} else if ( $search_type == 'Blog' ) {
					$data["results"] = $this->getBlogSearchData( $search_text, false );
				} else if ( $search_type == 'Case' ) {
					$data["results"] = $this->getCaseSearchData( $search_text, false );
				} else if ( $search_type == 'Service' ) {
					$data["results"] = $this->getServiceSearchData( $search_text, false );
				}
			}

			return view( 'page.search', $data );
		}
	}

	/**
	 * get package info by search text
	 *
	 * @param string $text search text
	 * @param bool $isHtmlReturn
	 *
	 * @return string
	 */
	private function getPackageSearchData( $text, $isHtmlReturn = true ) {
		$list     = '';
		$packages = Package::where( "title", "like", "%" . $text . "%" )
		                   ->orWhere( "subtitle", "like", "%" . $text . "%" )
		                   ->orWhere( "description", "like", "%" . $text . "%" )
		                   ->orWhere( "pricing_detail", "like", "%" . $text . "%" )
		                   ->paginate( config( "constant.smPagination" ) );
		if ( $isHtmlReturn ) {
			if ( count( $packages ) > 0 ) {
				foreach ( $packages as $package ) {
					$list .= '<a  class="list-group-item" target="_blank" href="' . url( 'packages/' . $package->slug ) . '">';
					$list .= $package->title;
					$list .= '</a>';
				}
			}

			return $list;
		} else {
			return $packages;
		}
	}

	/**
	 * Get blog search info by text
	 *
	 * @param $text string search text
	 * @param bool $isHtmlReturn
	 *
	 * @return string
	 */
	private function getBlogSearchData( $text, $isHtmlReturn = true ) {
		$list  = '';
		$blogs = Blog::where( "title", "like", "%" . $text . "%" )
		             ->orWhere( "short_description", "like", "%" . $text . "%" )
		             ->orWhere( "long_description", "like", "%" . $text . "%" )
		             ->paginate( config( "constant.smPagination" ) );
		if ( $isHtmlReturn ) {
			if ( count( $blogs ) > 0 ) {
				foreach ( $blogs as $blog ) {
					$list .= '<a  class="list-group-item" target="_blank" href="' . url( 'blog/' . $blog->slug ) . '">';
					if ( $blog->image != '' ) {
						$list .= '<img src="' . SM::sm_get_the_src( $blog->image, 80, 80 ) . '" alt="' . $blog->title . '">';
					}
					$list .= $blog->title;
					$list .= '</a>';
				}
			}

			return $list;
		} else {
			return $blogs;
		}
	}


	/**
	 * Get Service info by search text
	 *
	 * @param string $text search text
	 * @param bool $isHtmlReturn
	 *
	 * @return string
	 */
	private function getServiceSearchData( $text, $isHtmlReturn = true ) {
		$list     = '';
		$services = Service::where( "title", "like", "%" . $text . "%" )
		                   ->orWhere( "subtitle", "like", "%" . $text . "%" )
		                   ->orWhere( "short_description", "like", "%" . $text . "%" )
		                   ->orWhere( "description", "like", "%" . $text . "%" )
		                   ->orWhere( "features", "like", "%" . $text . "%" )
		                   ->orWhere( "extra", "like", "%" . $text . "%" )
		                   ->paginate( config( "constant.smPagination" ) );
		if ( $isHtmlReturn ) {
			if ( count( $services ) > 0 ) {
				foreach ( $services as $service ) {
					$list .= '<a  class="list-group-item" target="_blank" href="' . url( 'services/' . $service->slug ) . '">';
					if ( $service->image != '' ) {
						$list .= '<img src="' . SM::sm_get_the_src( $service->image, 80, 80 ) . '" alt="' . $service->title . '">';
					}
					$list .= $service->title;
					$list .= '</a>';
				}
			}

			return $list;
		} else {
			return $services;
		}
	}

	/**
	 * @param string $text search text
	 * @param bool $isHtmlReturn
	 *
	 * @return string
	 */
	private function getCaseSearchData( $text, $isHtmlReturn = true ) {
		$list  = '';
		$cases = Cases::where( "title", "like", "%" . $text . "%" )
		              ->orWhere( "description", "like", "%" . $text . "%" )
		              ->orWhere( "challenges", "like", "%" . $text . "%" )
		              ->orWhere( "solution", "like", "%" . $text . "%" )
		              ->paginate( config( "constant.smPagination" ) );
		if ( $isHtmlReturn ) {
			$data = [];
			if ( count( $cases ) > 0 ) {
				foreach ( $cases as $case ) {

					$list .= '<a  class="list-group-item" target="_blank" href="' . url( 'cases/' . $case->slug ) . '">';
					if ( $case->image != '' ) {
						$img = $case->image;
						if ( ! $image_array = explode( ',', $img ) ) {
							$image_array[0] = array( $img );
						}
						$list .= '<img src="' . SM::sm_get_the_src( $image_array[0], 80, 80 ) . '" alt="' . $case->title . '">';
					}
					$list .= $case->title;
					$list .= '</a>';
				}
			}

			return $list;
		} else {
			return $cases;
		}
	}

	/**
	 * Show package list page
	 */
	public function packages( $slug = null ) {
		if ( $slug != null ) {
			return $this->packageDetail( $slug );
		}
		$page             = \request()->input( 'page', 0 );
		$key              = 'package' . $page;
		$data['packages'] = SM::getCache( $key, function () {
			$package_posts_per_page = SM::smGetThemeOption( "package_posts_per_page", 12 );

			return Package::with( 'detail' )
			              ->where( "status", 1 )
			              ->orderBy( 'id', 'desc' )
			              ->paginate( $package_posts_per_page );
		}, [ 'package' ] );
		if ( count( $data['packages'] ) > 0 ) {
			return view( 'packages.package', $data );
		} else {
			return abort( 404 );
		}
	}


	/**
	 * Show package detail page by Search text
	 *
	 * @param $url
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
	 */
	public function packageDetail( $url ) {
		$data["packageInfo"] = SM::getCache( 'package_' . $url, function () use ( $url ) {
			return Package::where( 'slug', $url )
			              ->where( 'status', 1 )
			              ->first();
		} );
		if ( count( $data["packageInfo"] ) > 0 ) {
			$data['smAdminBarId'] = $data["packageInfo"]->id;
			$data["extra"]        = (object) SM::sm_unserialize( $data["packageInfo"]->extra );
			//seo data
			$data['seo_title']           = $data['packageInfo']->seo_title;
			$data['meta_key']            = $data['packageInfo']->meta_key;
			$data['meta_description']    = $data['packageInfo']->meta_description;
			$key                         = 'package_detail_' . $url;
			$data["packageInfo"]->detail = SM::getCache( $key, function () use ( $data ) {
				return Package_detail::where( "package_id", $data['packageInfo']->id )
				                     ->orderBy( 'sorting_position', 'asc' )
				                     ->get();
			} );

			return view( 'packages.package_detail', $data );
		} else {
			return abort( 404 );
		}
	}


	public function likes( Request $request ) {
		$this->validate( $request, [
			'id'   => 'required',
			'type' => 'required'
		] );
		$id     = base64_decode( urldecode( $request->id ) );
		$type   = $request->type;
		$suffix = $request->input( "suffix", 1 );
		if ( $type == 'blog' ) {
			$blog = Blog::find( $id );
			if ( $blog ) {
				$likeQuery = Like::where( 'likeable_id', $id )
				                 ->where( 'likeable_type', Blog::class );
				if ( Auth::check() ) {
					$likeQuery->where( 'liker_id', Auth::id() );
				} else {
					$likeQuery->where( 'liker_ip', $request->ip() );
				}
				$like = $likeQuery->first();
				if ( $like ) {
					if ( $like->status == 1 ) {
						if ( $blog->likes > 0 ) {
							$blog->decrement( 'likes' );
						}
						$like->status = 0;

						$data['isAlreadyLiked'] = 0;
					} else {
						$like->status = 1;
						$blog->increment( 'likes' );
						$data['isAlreadyLiked'] = 1;
					}
					$like->update();
				} else {
					$like                = new Like();
					$like->likeable_id   = $id;
					$like->likeable_type = Blog::class;
					if ( Auth::check() ) {
						$like->liker_id = Auth::id();
					}
					$like->liker_ip = $request->ip();
					$like->status   = 1;
					$like->save();
					$blog->increment( 'likes' );

					$data['isAlreadyLiked'] = 1;
				}
				$blogController = new Blogs();
				$blogController->removeThisCache( $blog->slug, $id );

				$data['likesTitle'] = SM::getCountTitle( $blog->likes, 'Like', $suffix );

				return $data;
			} else {
				return response( 'Blog Not Found', 404 );
			}
		} elseif ( $type == 'case' ) {
			$case = Cases::find( $id );
			if ( $case ) {
				$likeQuery = Like::where( 'likeable_id', $id )
				                 ->where( 'likeable_type', Cases::class );
				if ( Auth::check() ) {
					$likeQuery->where( 'liker_id', Auth::id() );
				} else {
					$likeQuery->where( 'liker_ip', $request->ip() );
				}
				$like = $likeQuery->first();
				if ( $like ) {
					if ( $like->status == 1 ) {
						if ( $case->likes > 0 ) {
							$case->decrement( 'likes' );
						}
						$like->status = 0;

						$data['isAlreadyLiked'] = 0;
					} else {
						$like->status = 1;
						$case->increment( 'likes' );
						$data['isAlreadyLiked'] = 1;
					}
					$like->update();
				} else {
					$like                = new Like();
					$like->likeable_id   = $id;
					$like->likeable_type = Cases::class;
					if ( Auth::check() ) {
						$like->liker_id = Auth::id();
					}
					$like->liker_ip = $request->ip();
					$like->status   = 1;
					$like->save();
					$case->increment( 'likes' );

					$data['isAlreadyLiked'] = 1;
				}
				$caseController = new \App\Http\Controllers\Admin\Common\Cases();
				$caseController->removeThisCache( $case->slug );

				$data['likesTitle'] = SM::getCountTitle( $case->likes, 'Like', $suffix );

				return $data;
			} else {
				return response( 'Case Not Found', 404 );
			}
		}


		return $request->all();
	}

	public function isAlreadyLiked( Request $request ) {
		$this->validate( $request, [
			'id'   => 'required',
			'type' => 'required'
		] );
		$id                     = base64_decode( urldecode( $request->id ) );
		$type                   = $request->type;
		$data['isAlreadyLiked'] = 0;
		if ( $type == 'blog' ) {
			$blog = Blog::find( $id );
			if ( $blog ) {
				$likeQuery = Like::where( 'likeable_id', $id )
				                 ->where( 'likeable_type', Blog::class );
				if ( Auth::check() ) {
					$likeQuery->where( 'liker_id', Auth::id() );
				} else {
					$likeQuery->where( 'liker_ip', $request->ip() );
				}
				$like = $likeQuery->first();
				if ( $like && $like->status == 1 ) {
					$data['isAlreadyLiked'] = 1;
				}
			}
		} elseif ( $type == 'case' ) {
			$case = Cases::find( $id );
			if ( $case ) {
				$likeQuery = Like::where( 'likeable_id', $id )
				                 ->where( 'likeable_type', Cases::class );
				if ( Auth::check() ) {
					$likeQuery->where( 'liker_id', Auth::id() );
				} else {
					$likeQuery->where( 'liker_ip', $request->ip() );
				}
				$like = $likeQuery->first();
				if ( $like && $like->status == 1 ) {
					$data['isAlreadyLiked'] = 1;
				}
			}
		}

		return $data;
	}
}