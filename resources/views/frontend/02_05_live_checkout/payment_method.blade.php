<div class="payment-area">
    <div class="heading">
        <h2>Payment Methods</h2>
        <hr>
    </div>
    <div class="payment-methods">
        <p class="title">Please select a prefered payment method to use on this
            order</p>

        <div class="alert alert-danger error_payment" style="display:none" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            Please select your payment method')
        </div>
        <ul class="list">
            @foreach($payment_methods as $payment_method)
                <li>
                    <label for="{{ $payment_method->id }}">
                        <input required type="radio" id="{{ $payment_method->id }}"
                               name="payment_method_id" class="payment_method"
                               value="{{ $payment_method->id }}">
                        {{ $payment_method->title }}
                    </label>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="submitButton">
        <button class="btn btn-success">Order Now</button>
    </div>
</div>