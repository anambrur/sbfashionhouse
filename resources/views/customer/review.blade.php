@extends('frontend.master')
@section("title", "Orders")
@section("content")
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-9">
                    <div class="account-panel">
                        <h2>Review List
                        </h2>
                        @if(count($reviews)>0)
                            <div class="account-panel-inner">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Ratings</th>
                                        <th>Review</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reviews as $review)
                                        <tr class="reviewRow">
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>
                                                <a href="{{ url('product/'.$review->product->slug) }}"><strong>{{ $review->product->title }}</strong></a>
                                            </td>
                                            <td>
                                                <div class="product-star" style="color: #ff9900;">
                                                    @for ($i = 0; $i < 5; ++$i)
                                                        <i class="fa fa-star{{ $review->rating<=$i?'-o':'' }}"
                                                           aria-hidden="true"></i>
                                                    @endfor

                                                </div>
                                            </td>
                                            <td>
                                                {{ $review->description }}
                                            </td>
                                            <td>
                                                <a data-review_id="{{ $review->id }}"
                                                   class="removeToReview btn btn-danger"
                                                   title="Remove item" href="javascript:void(0)"><i
                                                            class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                {!! $reviews->links('common.pagination_orders') !!}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fa fa-warning"></i> No Review Found!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection