@if(count($relatedProduct) > 0)
    <div class="page-product-box">
        <h2 class="section-heading">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.6144 17.7956C10.277 18.5682 9.20776 18.5682 8.8704 17.7956L7.99275 15.7854C7.21171 13.9966 5.80589 12.5726 4.0523 11.7942L1.63658 10.7219C.868536 10.381.868537 9.26368 1.63658 8.92276L3.97685 7.88394C5.77553 7.08552 7.20657 5.60881 7.97427 3.75892L8.8633 1.61673C9.19319.821767 10.2916.821765 10.6215 1.61673L11.5105 3.75894C12.2782 5.60881 13.7092 7.08552 15.5079 7.88394L17.8482 8.92276C18.6162 9.26368 18.6162 10.381 17.8482 10.7219L15.4325 11.7942C13.6789 12.5726 12.2731 13.9966 11.492 15.7854L10.6144 17.7956ZM4.53956 9.82234C6.8254 10.837 8.68402 12.5048 9.74238 14.7996 10.8008 12.5048 12.6594 10.837 14.9452 9.82234 12.6321 8.79557 10.7676 7.04647 9.74239 4.71088 8.71719 7.04648 6.85267 8.79557 4.53956 9.82234ZM19.4014 22.6899 19.6482 22.1242C20.0882 21.1156 20.8807 20.3125 21.8695 19.8732L22.6299 19.5353C23.0412 19.3526 23.0412 18.7549 22.6299 18.5722L21.9121 18.2532C20.8978 17.8026 20.0911 16.9698 19.6586 15.9269L19.4052 15.3156C19.2285 14.8896 18.6395 14.8896 18.4628 15.3156L18.2094 15.9269C17.777 16.9698 16.9703 17.8026 15.956 18.2532L15.2381 18.5722C14.8269 18.7549 14.8269 19.3526 15.2381 19.5353L15.9985 19.8732C16.9874 20.3125 17.7798 21.1156 18.2198 22.1242L18.4667 22.6899C18.6473 23.104 19.2207 23.104 19.4014 22.6899ZM18.3745 19.0469 18.937 18.4883 19.4878 19.0469 18.937 19.5898 18.3745 19.0469Z"></path></svg>
            Related Products
        </h2>
        <ul class="product-list owl-carousel" data-dots="true" data-loop="true" data-nav="false"
            data-margin="10" data-autoplayTimeout="1000" data-autoplayHoverPause="true"
            data-responsive='{"0":{"items":2},"600":{"items":3},"1000":{"items":4}}'>
            @foreach($relatedProduct as $rProductSingle)
                <li>
                    <div class="product-container">
                        <div class="left-block">
                            <a href="{{ url('product/'.$rProductSingle->slug) }}">
                                <img class="img-responsive" alt="{{ $rProductSingle->title }}"
                                     src="{!! SM::sm_get_the_src( $rProductSingle->image , 297, 297)!!}"/>
                            </a>
                            
                            @if($rProductSingle->sale_price>0)
                                <div class="price-percent-reduction2">
                                    {{ SM::productDiscount($rProductSingle->id) }}% OFF
                                </div>
                            @endif
                        </div>
                        <div class="right-block">
                            <div class="content_price">
                                <h5 class="product-name">
                                    <a href="{{ url('product/'.$rProductSingle->slug) }}">
                                        {{ $rProductSingle->title }}
                                    </a>
                                </h5>
                                @if($rProductSingle->sale_price>0)
                                <span class="price product-price">{{ SM::product_price($rProductSingle->sale_price) }}</span>
                                <span class="price old-price">{{ SM::product_price($rProductSingle->regular_price) }}</span>
                                @else
                                <span class="price product-price">{{ SM::product_price($rProductSingle->regular_price) }}</span>
                                @endif
                            </div>
                            <div class="quick-view">
                                <?php echo SM::addToCartButton($rProductSingle->id, $rProductSingle->regular_price, $rProductSingle->sale_price);?>
                                <?php echo SM::quickViewHtml($rProductSingle->id, $rProductSingle->slug);?>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif