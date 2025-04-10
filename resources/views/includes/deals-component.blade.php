<!-- Start related-product Area -->
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Deals of the Week</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore
                        magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @if($deals->count())
                    @foreach($deals as $deal)
                    @php $product = $deal->product; @endphp
                    @if($product)
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                        <div class="single-related-product d-flex">
                            <a href="#" class="deal_img">
                                <img src="{{ url('public/product_images/' . $product->firstImage->images) }}" alt="">
                            </a>
                            <div class="desc">
                                <a href="#" class="title">{{ $product->title }}</a>
                                <div class="price">
                                    <h6>${{ $product->old_price }}</h6>
                                    @if($deal->discount_percentage)
                                    <b class="bold-text">{{ $deal->discount_percentage }}% OFF</b>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <p>No deal of the week available.</p>
                    @endif

                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="{{url('public/front/img/category/c5.jpg')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End related-product Area -->
<!-- product image you will get from product_image table -->