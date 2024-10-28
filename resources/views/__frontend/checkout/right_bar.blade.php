<div class="col-12 col-lg-4 checkout-right">
    <div class="order-summary-outer">
        <div class="order-summary">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2">Order Summary</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th><span>SubTotal</span></th>
                        <td align="right"
                            id="subtotal">{{ SM::currency_price_value($sub_total) }}</td>
                    </tr>
                    <tr>
                        <th><span>Tax</span></th>
                        <td align="right">{{ SM::currency_price_value($tax) }}</td>
                    </tr>
                    <tr>
                        <th><span>Shipping Cost</br>
                                <small> {{ $shipping_method_name }}</small></span></th>
                        <td align="right">{{ SM::currency_price_value($shipping_method_charge) }}</td>
                    </tr>
                    @if($noraml_discount_amount>0)
                        <tr>
                            <th><span>Discount (Normal)
                                @if($discount_amount>0)
                                        - {{ $discount_amount }} %
                                    @endif
                                </span></th>
                            <td align="right"
                                id="discount">
                                {{ SM::currency_price_value($noraml_discount_amount) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th><span>Discount(Coupon)</span></th>
                        <td align="right"
                            id="discount">
                            {{ SM::currency_price_value($coupon_amount) }}</td>
                    </tr>
                    <tr>
                        <th class="last"><span>Total</span></th>
                        <td class="last" align="right"
                            id="total_price">{{ SM::currency_price_value($grand_total) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="coupons">
            <!-- applied copuns -->
            {{--<form id="apply_coupon">--}}
            <div class="form-group">
                <label for="inputPassword2" class="">Coupon Code</label>
                <input type="text" name="coupon_code" class="form-control" id="coupon_code" autocomplete="off">
                <input type="hidden" name="sub_total_price" value="{{ $net_sub_total }}"
                       class="form-control"
                       id="sub_total_price">
            </div>
            <button type="submit"
                    class="btn btn-sm btn-success apply_coupon">ApplyCoupon
            </button>
            <div id="coupon_error" style="display: none"></div>
            <div id="coupon_require_error"
                 style="display: none">Please enter a valid coupon code
            </div>
            {{--</form>--}}
        </div>
    </div>
</div>