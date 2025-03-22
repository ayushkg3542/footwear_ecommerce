<!--start footer-->
<!-- <footer class="page-footer">
    <p class="mb-0">Copyright © 2023. All right reserved.</p>
</footer> -->
<!--top footer-->

<!--start cart-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header border-bottom h-70">
        <h5 class="mb-0" id="offcanvasRightLabel">{{ $orderCount }} New Orders</h5>
        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
            <i class="material-icons-outlined">close</i>
        </a>
    </div>
    <div class="offcanvas-body p-0">
        <div class="order-list">
            @if($orderCount > 0)
            @foreach($todayOrders as $order)
            @foreach($order->orderItems as $item)
            <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                <div class="order-img">
                    <img src="{{ url('public/product_images/' . ($item->product->images->first()->images ?? 'default.png')) }}"
                        class="img-fluid rounded-3" width="75" alt="{{ $item->product->title }}">
                </div>
                <div class="order-info flex-grow-1">
                    <h5 class="mb-1 order-title">{{ $item->product->title }}</h5>
                    <p class="mb-0 order-price">₹{{ number_format($item->product->new_price, 2) }}</p>
                </div>
                <div class="d-flex">
                    <a class="order-view text-dark" href="{{ route('order.details') }}">
                        <span class="material-icons-outlined">visibility</span>
                    </a>
                </div>
            </div>
            @endforeach
            @endforeach
            @else
            <div class="p-3 text-center">No orders placed today.</div>
            @endif
        </div>
    </div>
    <div class="offcanvas-footer h-70 p-3 border-top">
        <div class="d-grid">
            <button type="button" class="btn btn-dark" data-bs-dismiss="offcanvas">View Products</button>
        </div>
    </div>
</div>
<!--end cart-->

<!--start switcher-->
<button class="btn btn-primary position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" type="button"
    data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
    <i class="material-icons-outlined">tune</i>Customize
</button>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
    <div class="offcanvas-header border-bottom h-70">
        <div class="">
            <h5 class="mb-0">Theme Customizer</h5>
            <p class="mb-0">Customize your theme</p>
        </div>
        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
            <i class="material-icons-outlined">close</i>
        </a>
    </div>
    <div class="offcanvas-body">
        <div>
            <p>Theme variation</p>

            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="LightTheme" checked>
                    <label
                        class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                        for="LightTheme">
                        <span class="material-icons-outlined">light_mode</span>
                        <span>Light</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
                    <label
                        class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                        for="DarkTheme">
                        <span class="material-icons-outlined">dark_mode</span>
                        <span>Dark</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
                    <label
                        class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                        for="SemiDarkTheme">
                        <span class="material-icons-outlined">contrast</span>
                        <span>Semi Dark</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
                    <label
                        class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                        for="BoderedTheme">
                        <span class="material-icons-outlined">border_style</span>
                        <span>Bordered</span>
                    </label>
                </div>
            </div>
            <!--end row-->

        </div>
    </div>
</div>
<!--start switcher-->

<!--bootstrap js-->
<script src="{{url('public/admin/assets/js/bootstrap.bundle.min.js')}}"></script>

<!--plugins-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<!--plugins-->
<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{url('public/admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{url('public/admin/assets/plugins/metismenu/metisMenu.min.js')}}"></script>
<script src="{{url('public/admin/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
<script src="{{url('public/admin/assets/js/index.js')}}"></script>
<script src="{{url('public/admin/assets/plugins/peity/jquery.peity.min.js')}}"></script>
<script src="{{url('public/admin/assets/plugins/fancy-file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{url('public/admin/assets/plugins/fancy-file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{url('public/admin/assets/plugins/fancy-file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{url('public/admin/assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js')}}"></script>
<script src="{{url('public/admin/assets/summernote/summernote.min.js')}}"></script>

<script>
$(".data-attributes span").peity("donut")
</script>
<script src="{{url('public/admin/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{url('public/admin/assets/js/main.js')}}"></script>