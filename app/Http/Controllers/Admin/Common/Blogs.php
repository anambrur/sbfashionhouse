<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Comment;
use App\Model\Common\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use App\Model\Common\Blog;
use App\Model\Common\Category;
use Illuminate\Support\Facades\Cache;

class Blogs extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Blog';
        $data['rightButton']['link'] = 'blogs/create';
        $data['all_blog'] = Blog::orderBy("id", "desc")
                ->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/blog/blogs', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['all_blog']
                    ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/blog/manage_blog", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['rightButton']['iconClass'] = 'fa fa-list';
        $data['rightButton']['text'] = 'Blog List';
        $data['rightButton']['link'] = 'blogs';
        $data["all_categories"] = Category::where("parent_id", 0)->get();

        return view("nptl-admin/common/blog/add_blog", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'image' => "required",
            'categories' => 'required|array',
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $blog = new Blog();
        $blog->title = $request->input("title");
        $blog->short_description = $request->input("short_description", "");
        $blog->long_description = $request->input("long_description", "");
        $blog->seo_title = $request->input("seo_title", "");
        $blog->meta_key = $request->input("meta_key", "");
        $blog->meta_description = $request->input("meta_description", "");
        $blog->is_sticky = isset($request->is_sticky) && $request->is_sticky == 'on' ? 1 : 0;
        $blog->comment_enable = isset($request->comment_enable) && $request->comment_enable == 'on' ? 1 : 0;
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
                isset($permission['blogs']['blog_status_update']) && $permission['blogs']['blog_status_update'] == 1) {
            $blog->status = $request->status;
        }
        if (isset($request->image) && $request->image != '') {
            $blog->image = $request->image;
        }
        $slug = ( trim($request->slug) != '' ) ? $request->slug : $request->title;
        $blog->slug = SM::create_uri('blogs', $slug);
        $blog->created_by = SM::current_user_id();

        if ($blog->save()) {
            foreach ($request->categories as $cat) {
                $categories[$cat]['created_at'] = date("Y-m-d H:i:s");
                $categories[$cat]['updated_at'] = date("Y-m-d H:i:s");
                $catInfo = Category::find($cat);
                if (count((array)$catInfo) > 0) {
                    $catInfo->increment("total_posts");
                }
            }
            $blog->categories()->attach($categories);


            $tags = SM::insertTag($request->input("tags", ""));
            if ($tags) {
                foreach ($tags as $tag) {
                    $insTags[$tag]['created_at'] = date("Y-m-d H:i:s");
                    $insTags[$tag]['updated_at'] = date("Y-m-d H:i:s");
                    $tagInfo = Tag::find($tag);
                    if ($tagInfo) {
                        $tagInfo->increment("total_posts");
                    }
                }
                if ($insTags) {
                    $blog->tags()->attach($insTags);
                }
            }
            $this->removeThisCache();

            return redirect(SM::smAdminSlug("blogs/$blog->id/edit"))->with("s_message", "Blog successfully saved!");
        } else {
            return redirect(SM::smAdminSlug("blogs"))->with("w_message", "Blog save failed!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//	public function show( $id ) {
//		//
//	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data["blog_info"] = Blog::with("categories", "tags")->find($id);
        if (count((array)$data["blog_info"]) > 0) {
            $data['rightButton']['iconClass'] = 'fa fa-list';
            $data['rightButton']['text'] = 'Blog List';
            $data['rightButton']['link'] = 'blogs';
            $data['rightButton2']['iconClass'] = 'fa fa-eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "blog/" . $data['blog_info']->slug;

            $data['blog_info']->categories = SM::get_ids_from_data($data['blog_info']->categories);
            $data['blog_info']->tags = SM::sm_get_product_tags($data['blog_info']->tags);
            $data['all_categories'] = Category::where('parent_id', 0)->get();

            return view("nptl-admin/common/blog/edit_blog", $data);
        } else {
            return redirect(SM::smAdminSlug("categories"))->with("w_message", "Blog Not Found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required|max:100',
            'image' => "required",
            'categories' => 'required|array',
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);

        $blog = Blog::with('tags', 'categories')->find($id);
        if (count((array)$blog) > 0) {
            $this->removeThisCache($blog->slug, $blog->id);
            $blog->title = $request->input("title");
            $blog->short_description = $request->input("short_description", "");
            $blog->long_description = $request->input("long_description", "");
            $blog->seo_title = $request->input("seo_title", "");
            $blog->meta_key = $request->input("meta_key", "");
            $blog->meta_description = $request->input("meta_description", "");
            $blog->is_sticky = isset($request->is_sticky) && $request->is_sticky == 'on' ? 1 : 0;
            $blog->comment_enable = isset($request->comment_enable) && $request->comment_enable == 'on' ? 1 : 0;
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['blogs']['blog_status_update']) && $permission['blogs']['blog_status_update'] == 1) {
                $blog->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $blog->image = $request->image;
            }

            $slug = ( trim($request->slug) != '' ) ? $request->slug : $request->title;
            $blog->slug = SM::create_uri('blogs', $slug, $id);
            $blog->modified_by = SM::current_user_id();
            $updateCount = $blog->update();
            if ($updateCount > 0) {
                $oldCatIds = SM::get_ids_from_data($blog->categories);
                foreach ($request->categories as $cat) {
                    $categories[$cat]['created_at'] = date("Y-m-d H:i:s");
                    $categories[$cat]['updated_at'] = date("Y-m-d H:i:s");
                    if (!in_array($cat, $oldCatIds)) {
                        $catInfo = Category::find($cat);
                        if (count((array)$catInfo) > 0) {
                            $catInfo->increment("total_posts");
                        }
                    }
                }
                $blog->categories()->sync($categories);


                $tags = SM::insertTag($request->input("tags", ""));
                $oldTagIds = SM::get_ids_from_data($blog->tags);
                if ($tags) {
                    foreach ($tags as $tag) {
                        $insTags[$tag]['created_at'] = date("Y-m-d H:i:s");
                        $insTags[$tag]['updated_at'] = date("Y-m-d H:i:s");
                        $tagInfo = Tag::find($tag);
                        if (!in_array($tag, $oldTagIds)) {
                            if (count((array)$tagInfo) > 0) {
                                $tagInfo->increment("total_posts");
                            }
                        }
                    }
                    if ($insTags) {
                        $blog->tags()->sync($insTags);
                    }
                }

                return redirect(SM::smAdminSlug("blogs/$id/edit"))->with("s_message", "Blog Updated Successfully!");
            } else {
                return redirect(SM::smAdminSlug("blogs/$id/edit"))->with("s_message", "Blog Update Failed!");
            }
        } else {
            return redirect(SM::smAdminSlug("blogs"))->with("w_message", "Blog Not Found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $blog = Blog::with('categories', 'tags')->find($id);
        if (count((array)$blog) > 0) {
            $comments = Comment::where('commentable_id', $id)
                    ->where('commentable_type', Blog::class)
                    ->get();
            if (count((array)$comments) > 0) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            if (count((array)$blog->categories) > 0) {
                foreach ($blog->categories as $category) {
                    if ($category->total_posts > 0) {
                        $category->decrement('total_posts');
                    }
                }
            }
            if (count((array)$blog->tags) > 0) {
                foreach ($blog->tags as $tag) {
                    if ($tag->total_posts > 0) {
                        $tag->decrement('total_posts');
                    }
                }
            }
            $this->removeThisCache($blog->slug, $blog->id);

            if ($blog->delete() > 0) {
                return response(1);
            }
        }

        return response(0);
    }

    /**
     * status change the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return null
     */
    public function blog_status_update(Request $request) {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $blog = Blog::find($request->post_id);
        if (count((array)$blog) > 0) {
            $this->removeThisCache($blog->slug, $blog->id);
            $blog->status = $request->status;
            $blog->update();
        }
        exit;
    }

    /**
     * Get all comment info
     */
    public function comments() {
        $data["comments"] = Comment::leftJoin("blogs", function ( $query ) {
                    $query->on("blogs.id", "=", "comments.commentable_id")
                    ->where("comments.commentable_type", "=", 'App\Model\Common\Blog');
                })
                ->where("comments.p_c_id", 0)
                ->select('comments.*', 'blogs.title as blog_title')
                ->orderBy("comments.id", "desc")
                ->paginate(config("constant.smPagination"));

        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/blog/comments', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['comments']
                    ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/blog/manage_comments", $data);
    }

    public function edit_comment($id) {
        $data['comment'] = Comment::leftJoin("blogs", function ( $query ) {
                    $query->on("blogs.id", "=", "comments.commentable_id")
                    ->where("comments.commentable_type", "=", 'App\Model\Common\Blog');
                })
                ->where("comments.id", $id)
                ->select('comments.*', 'blogs.title as blog_title')
                ->first();

        return view("nptl-admin/common/blog/edit_comment", $data);
    }

    public function update_comment(Request $request, $id) {
        $this->validate($request, ["comments" => "required"]);
        $comment = Comment::find($id);
        if (count((array)$comment) > 0) {
            $comment->comments = $request->comments;
            $comment->modified_by = SM::current_user_id();
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['blogs']['comment_status_update']) && $permission['blogs']['comment_status_update'] == 1) {

                if ($comment->commentable_type == Blog::class) {
                    $blog = Blog::find($comment->commentable_id);
                    if ($blog) {
                        if ($comment->status == 1 && ( $request->status == 2 || $request->status == 3 )) {
                            $blog->decrement("comments");
                        }
                        if ($request->status == 1 && ( $comment->status == 2 || $comment->status == 3 )) {
                            $blog->increment("comments");
                        }
                        $this->removeThisCache($blog->slug, $comment->commentable_id);
                    } else {
                        $this->removeThisCache(null, $comment->commentable_id);
                    }
                } else {
                    $this->removeThisCache(null, $comment->commentable_id);
                }


                $comment->status = $request->status;
            } else {
                $this->removeThisCache(null, $comment->commentable_id);
            }
            $comment->update();

            return redirect(SM::smAdminSlug("blogs/comments"))->with("s_message", "Comment updated successfully!");
        }

        return redirect(SM::smAdminSlug("blogs/comments"))->with("w_message", "Comment not found!");
    }

    public function reply_comment($id) {
        $data['comment'] = Comment::leftJoin("blogs", function ( $query ) {
                    $query->on("blogs.id", "=", "comments.commentable_id")
                    ->where("comments.commentable_type", "=", 'App\Model\Common\Blog');
                })
                ->where("comments.id", $id)
                ->select('comments.*', 'blogs.title as blog_title')
                ->first();

        return view("nptl-admin/common/blog/reply_comment", $data);
    }

    public function save_reply(Request $request) {
        $this->validate($request, [
            "p_c_id" => "required",
            "commentable_id" => "required",
            "commentable_type" => "required",
            "reply" => "required",
        ]);
        $blog = Blog::find($request->commentable_id);
        if ($blog) {
            $blog->increment("comments");

            $comment = new Comment();
            $comment->p_c_id = $request->p_c_id;
            $comment->commentable_id = $request->commentable_id;
            $comment->commentable_type = $request->commentable_type;
            $comment->comments = $request->reply;
            $comment->created_by = 1;
            $comment->modified_by = 1;
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['blogs']['reply_comment']) && $permission['blogs']['reply_comment'] == 1) {
                $comment->status = $request->status;
            }
            $comment->save();
            $this->removeThisCache(null, $request->commentable_id);

            return redirect(SM::smAdminSlug("blogs/comments"))->with("s_message", "Comment reply saved successfully!");
        } else {
            return response("Blog Not Found!", 404);
        }
    }

    /**
     * delete comment
     *
     * @param $id integer
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_comment($id) {
        $comment = Comment::find($id);
        if (count((array)$comment) > 0) {
            if ($comment->commentable_type == Blog::class && $comment->status == 1) {
                $blog = Blog::find($comment->commentable_id);
                if ($blog) {
                    $blog->decrement("comments");

                    $this->removeThisCache($blog->slug, $comment->commentable_id);
                } else {
                    $this->removeThisCache(null, $comment->commentable_id);
                }
            } else {
                $this->removeThisCache(null, $comment->commentable_id);
            }
            if ($comment->delete() > 0) {
                return response(1);
            }
        }

        return response(0);
    }

    /**
     * update comment status
     *
     * @param Request $request
     */
    public function comment_status_update(Request $request) {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $comment = Comment::find($request->post_id);
        if (count((array)$comment) > 0) {
            if ($comment->commentable_type == Blog::class) {
                $blog = Blog::find($comment->commentable_id);
                if ($blog) {
                    if ($comment->status == 1 && ( $request->status == 2 || $request->status == 3 )) {
                        $blog->decrement("comments");
                    }
                    if ($request->status == 1 && ( $comment->status == 2 || $comment->status == 3 )) {
                        $blog->increment("comments");
                    }
                    $this->removeThisCache($blog->slug, $comment->commentable_id);
                } else {
                    $this->removeThisCache(null, $comment->commentable_id);
                }
            } else {
                $this->removeThisCache(null, $comment->commentable_id);
            }
            $comment->status = $request->status;
            $comment->update();
        }
        exit;
    }

    public function removeThisCache($slug = null, $id = null) {
        SM::removeCache('homeBlogs');
        SM::removeCache('sidebar_popular_blog');
        if ($slug != null) {
            SM::removeCache('blog_' . $slug);
            SM::removeCache('blog_related_blog_' . $slug);
        }
        if ($id != null) {
            SM::removeCache(['blog_comments_count_' . $id], 1);
            SM::removeCache(['blog_comments_' . $id], 1);
        }
        SM::removeCache(['categoryBlogs'], 1);
        SM::removeCache(['tagBlogs'], 1);
        SM::removeCache(['blogs'], 1);
        SM::removeCache(['stickyBlogs'], 1);
    }

}
