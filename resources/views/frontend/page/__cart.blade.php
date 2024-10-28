@extends('frontend.layout')

@section('title', 'Cart')

@section('content')

    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>
        <form action="{{url('update-cart')}}" method="post">
            {{ csrf_field() }}
            <?php
            $items = Cart::Content();
            ?>
            @if($items)
                @foreach($items as $id => $item)
                    <tr>
                        <input type="hidden" name="rowId" value="{{$item->rowId}}">
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs"><img
                                            src="{!! SM::sm_get_the_src($item->options->image) !!}"
                                            width="100" height="100" class="img-responsive"/></div>
                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{ $item->name }}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">${{ $item->price }}</td>
                        <td data-th="Quantity">
                            <input type="number" value="{{ $item->qty }}" name="qty" class="form-control quantity"/>
                        </td>
                        <td data-th="Subtotal" class="text-center">${{ $item->price * $item->qty }}</td>
                        <td class="actions" data-th="">


                            <button class="btn btn-info btn-sm update-cart"><i
                                        class="fa fa-refresh"></i></button>

                            <a onclick="return confirm('Are you sure you want to remove this item?');"
                               class="btn btn-danger btn-sm remove-from-cart"
                               href="{{URL::to('/delete-to-cart/'.$item->rowId)}}"><i
                                        class="fa fa-trash-o"></i></a>
                        </td>

                    </tr>
                @endforeach
            @endif
        </form>
        </tbody>
        <tfoot>
        <tr class="visible-xs">
            <td colspan="6" class="text-right"><strong>Sub Total </strong>: {{Cart::subTotal()}}</td>
        </tr>
        <tr class="visible-xs">
            <td colspan="6" class="text-right"><strong>Tax </strong>: {{Cart::tax()}}</td>
        </tr>
        <tr class="visible-xs">
                <td colspan="6" class="text-right"><strong>Total </strong>: {{Cart::total()}}</td>
        </tr>
        <tr>
            <td colspan="3">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
            </td>
            <td colspan="3" class="hidden-xs">
                @if(Auth::check())
                    <a href="{{ url('/checkout') }}" class="btn btn-success pull-right"> Place Order <i
                                class="fa fa-angle-right"></i>
                    </a>
                @else
                    <button type="button" class="btn btn-success pull-right" id="loginBtn">Place Order <i
                                class="fa fa-angle-right"></i></button>
                    </a>
                @endif
            </td>

        </tr>
        </tfoot>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="loginModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">login</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="username" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-primary pull-right" id="registerBtn">Register <i
                                    class="fa fa-angle-right"></i></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="registerModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Register</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="registrationForm" class="smAuthForm" action="{{ url('/register') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1"
                                   placeholder="Password">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-success pull-right" id="registerBtn">Register <i
                                    class="fa fa-angle-right"></i></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>

        </div>
    </div>
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#loginBtn").click(function () {
                $("#loginModal").modal('show');
            });
            $("#registerBtn").click(function () {
                $("#registerModal").modal('show');
                $("#loginModal").modal('hide');
            });
        });
    </script>

    {{--<script type="text/javascript">--}}

    {{--$(".update-cart").click(function (e) {--}}
    {{--e.preventDefault();--}}

    {{--var ele = $(this);--}}

    {{--$.ajax({--}}
    {{--url: '{{ url('update-cart') }}',--}}
    {{--method: "patch",--}}
    {{--data: {--}}
    {{--_token: '{{ csrf_token() }}',--}}
    {{--id: ele.attr("data-id"),--}}
    {{--quantity: ele.parents("tr").find(".quantity").val()--}}
    {{--},--}}
    {{--success: function (response) {--}}
    {{--window.location.reload();--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}

    {{--$(".remove-from-cart").click(function (e) {--}}
    {{--e.preventDefault();--}}

    {{--var ele = $(this);--}}

    {{--if (confirm("Are you sure")) {--}}
    {{--$.ajax({--}}
    {{--url: '{{ url('remove-from-cart') }}',--}}
    {{--method: "DELETE",--}}
    {{--data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},--}}
    {{--success: function (response) {--}}
    {{--window.location.reload();--}}
    {{--}--}}
    {{--});--}}
    {{--}--}}
    {{--});--}}

    {{--</script>--}}

@endsection
@endsection