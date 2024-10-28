@push('style')
    <style>

        fieldset, label {
            margin: 0;
            padding: 0;
        }

        /****** Style Star Rating Widget *****/
        .rating > input {
            display: none;
        }

        .rating > label:before {
            margin: 5px;
            font-size: 1.25em;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
            content: "\f089";
            position: absolute;
        }

        /***** CSS Magic to Highlight Stars on Hover *****/
        .rating > input:checked ~ label, /* show gold star when clicked */
        .rating:not(:checked) > label:hover, /* hover current star */
        .rating:not(:checked) > label:hover ~ label {
            color: #ff9900;
        }

        /* hover previous stars in list */
        .rating > input:checked + label:hover, /* hover current star when changing rating */
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
        .rating > input:checked ~ label:hover ~ label {
            color: #ff9900;
        }

    </style>

@endpush

<div id="reviews" class="tab-panel">
    <div class="product-comments-block-tab">
        <div class="row">
            <form class="ajaxReviewForm">
                <div class="col-md-12">
                    {!! Form::hidden('product_id', $product->id, ['class' => 'form-control product_id']) !!}
                    <div class="form-group">
                        <label for="description">Your review</label>
                        {!! Form::textarea('description', null, ['class' => 'form-control description', 'required', 'id'=>'product_review', 'height'=>'20px', 'placeholder'=> 'Description']) !!}
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating</label><br>
                        <fieldset class="rating">
                            <input type="radio" class="product_rating" id="star5" name="rating" value="5"/>
                            <label class="full" for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" class="product_rating" id="star4" name="rating" value="4"/>
                            <label class="full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" class="product_rating" id="star3" name="rating" value="3"/>
                            <label class="full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" class="product_rating" id="star2" name="rating" value="2"/>
                            <label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" class="product_rating" id="star1" name="rating" value="1"/>
                            <label class="full" for="star1" title="Sucks big time - 1 star"></label>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <button class="button btn-comment ajaxReviewSubmit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
                    </div>
                </div>
            </form>
        </div>

        @foreach($product->reviews->where('status', 1) as $review)
            <div class="comment row">
                <div class="col-sm-3 author">
                    <div class="info-author">
                        <span><strong>{{ $review->user->username }}</strong></span>
                        <em>{{ SM::showDateTime($review->created_at) }}</em>
                    </div>

                    <div class="grade">
                        <span>{{ $review->title }}</span>
                        <span class="reviewRating">
                            @for ($i = 0; $i < 5; ++$i)
                                <i class="fa fa-star{{ $review->rating<=$i?'-o':'' }}" aria-hidden="true"></i>
                            @endfor
                        </span>
                    </div>
                </div>

                <div class="col-sm-9 commnet-dettail">
                    {{ $review->description }}
                </div>
            </div>
        @endforeach
    </div>
</div>

@if (Auth::check())

@else
    @push('script')
        <script type="text/javascript">
            $(document).ready(function () {
                $("#product_review").click(function () {
                    $('.loginModal').modal('show');
                });
            });
        </script>
    @endpush
@endif

 