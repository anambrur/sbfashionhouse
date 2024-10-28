@extends("nptl-admin.master")
@section("title", "Edit Reply")
@section("content")
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
        {!! Form::model($comment,["method"=>"post","action"=>["Admin\Common\Blogs@save_reply"]]) !!}
        <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-reply-comment">
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
                        <span class="widget-icon"> <i class="fa fa-comment"></i> </span>
                        <h2>Reply Comment </h2>

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


                            <fieldset>
                                <div class="form-group{{ $errors->has('menu_title') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="menu_title">Blog Title</label>
                                    <div class="col-md-10">
                                        <input name="p_c_id" type="hidden"
                                               value="{{ $comment->id }}">
                                        <input name="commentable_type" type="hidden"
                                               value="{{ $comment->commentable_type }}">
                                        <input name="commentable_id" type="hidden"
                                               value="{{ $comment->commentable_id }}">
                                        <input name="blog_title" id="blog_title" class="form-control"
                                               placeholder="Blog Title" type="text"
                                               value="{{ $comment->blog_title }}" readonly>
<br>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="comments">Comments</label>
                                    <div class="col-md-10">
                                        <textarea readonly name="comments" id="comments" class="form-control"
                                                  placeholder="Content Description" rows="4"
                                                  required="">{!! stripslashes($comment->comments); !!}</textarea>
                                        @if ($errors->has('comments'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('comments') }}</strong>
                                              </span>
                                        @endif
                                        <br>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('reply') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="reply">Reply</label>
                                    <div class="col-md-10">
                                        <textarea name="reply" id="reply" class="form-control"
                                                  placeholder="Reply a comment" rows="10"
                                                  required=""></textarea>
                                        @if ($errors->has('reply'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('reply') }}</strong>
                                              </span>
                                        @endif
                                        <br>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">

                                    <label class="col-md-2 control-label" for="status">Publication Status</label>
                                    <div class="col-md-10">

                                        <select name="status" id="status" class="form-control" required="">
                                            <option value="1" {{ $comment->status == 1 ? 'selected': '' }}>Publish</option>
                                            <option value="2" {{ $comment->status == 2 ? 'selected': '' }}>Pending</option>
                                            <option value="3" {{ $comment->status == 3 ? 'selected': '' }}>Cancel</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('status') }}</strong>
                                             </span>
                                        @endif

                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-save"></i>
                                            Save Reply
                                        </button>
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
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection