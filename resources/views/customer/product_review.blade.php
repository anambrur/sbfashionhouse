<!--Login model-->
<div class="modal fade" id="productReviewModal" role="dialog">
    <div class="row">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="pull-right">

                            <button type="button" class="close-style-ex" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 panel-style ">
                            {{ Form::open(['route' => ['review.store'], 'id' => 'exampleupdateform']) }}
                            {!! Form::hidden('product_id', $product->id, ['class' => 'form-control']) !!}
                            {!! Form::hidden('user_id', Auth::id(), ['class' => 'form-control']) !!}
                            <h3 class="m-log">Product Review</h3>
                            <label for="rating" class="m-label">Rateing<span> * </span></label><br>
                            <div class="rate">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div>
                            <label for="title" class="m-label">Title<span> * </span></label>
                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder'=> 'Title']) !!}
                            <label for="description" class="m-label">Description<span> * </span></label>
                            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder'=> 'Description']) !!}

                            <p class="forgot-pass m-log"><a href="#">Forgot your password?</a></p>
                            <button type="submit" class="button btn-lg button-style"><i class="fa fa-lock"></i>
                               Submit
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
