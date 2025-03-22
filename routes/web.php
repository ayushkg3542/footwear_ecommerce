<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\WishlistController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'adminauthenticate'])->name('login.submit');
    Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('/processForgotPassword', [AuthController::class, 'processForgotPassword'])->name('processForgotPassword');
    Route::get('/resetPassword/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
    Route::post('/processResetPassword', [AuthController::class, 'processResetPassword'])->name('processResetPassword');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth.custom'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

        // ============== ADD CATEGORY ==============
        Route::get('/category', [MasterController::class, 'category'])->name('category');
        Route::post('/storeCategory', [MasterController::class, 'storeCategory'])->name('storeCategory');
        Route::post('/getCategory', [MasterController::class, 'getCategory'])->name('getCategory');
        Route::post('/modifyCategory', [MasterController::class, 'modifyCategory'])->name('modifyCategory');

        Route::get('/getSlug', function(Illuminate\Http\Request $request){
            $slug = '';
            $category = $request->category;
            if(!empty($category)){
                $slug = Str::slug($category);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug,
                'category'=>$category
            ]);
        })->name('getSlug');
       


        // ============== ADD SUB-CATEGORY ==============
        Route::get('/subcategory', [MasterController::class, 'subcategory'])->name('subcategory');
        Route::post('/storesubCategory', [MasterController::class, 'storesubCategory'])->name('storesubCategory');
        Route::post('/getsubCategory', [MasterController::class, 'getsubCategory'])->name('getsubCategory');
        Route::post('/modifysubCategory', [MasterController::class, 'modifysubCategory'])->name('modifysubCategory');

        // ============== ADD BRAND ==============
        Route::get('/brand', [MasterController::class, 'brand'])->name('brand');
        Route::post('/storeBrand', [MasterController::class, 'storeBrand'])->name('storeBrand');
        Route::post('/getBrand', [MasterController::class, 'getBrand'])->name('getBrand');
        Route::post('/modifyBrand', [MasterController::class, 'modifyBrand'])->name('modifyBrand');

        // ============== ADD BRAND ==============
        Route::get('/color', [MasterController::class, 'color'])->name('color');
        Route::post('/storeColor', [MasterController::class, 'storeColor'])->name('storeColor');
        Route::post('/getColor', [MasterController::class, 'getColor'])->name('getColor');
        Route::post('/modifyColor', [MasterController::class, 'modifyColor'])->name('modifyColor');

        Route::post('/delete-entity', [MasterController::class, 'deleteEntity'])->name('deleteEntity');


        Route::get('/getBrandSlug', function(Illuminate\Http\Request $request){
            $slug = '';
            $brand = $request->brand;
            if(!empty($brand)){
                $slug = Str::slug($brand);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug,
                'brand'=>$brand
            ]);
        })->name('getBrandSlug');


        // ============= PRODUCTS =================
        Route::get('/allProducts',[ProductController::class, 'allProducts'])->name('allProducts');
        Route::get('/addProducts',[ProductController::class, 'addProducts'])->name('addProducts');
        Route::post('/product/temporary-upload', [ProductController::class, 'temporaryUpload']);
        Route::post('/storeProducts', [ProductController::class, 'storeProducts'])->name('storeProducts');
        Route::get('/getproductSlug', function(Illuminate\Http\Request $request){
            $slug = '';
            $title = $request->title;
            if(!empty($title)){
                $slug = Str::slug($title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug,
                'title'=>$title
            ]);
        })->name('getproductSlug');
        Route::get('/getSubcategories', [ProductController::class, 'getSubcategories'])->name('getSubcategories');
        Route::post('/productDestroy/{id}', [ProductController::class,'destroy'])->name('productDestroy');
        Route::get('/editProduct/{id}',[ProductController::class, 'editProduct'])->name('editProduct');
        Route::post('/modifyProduct/{id}', [ProductController::class, 'modifyProduct'])->name('modifyProduct');

        Route::get('/couponList',[CouponController::class, 'couponList'])->name('couponList');
        Route::get('/manageCoupon/{id}',[CouponController::class, 'manageCoupon'])->name('manageCoupon');
        Route::post('/storeCoupon', [CouponController::class, 'storeCoupon'])->name('storeCoupon');
        Route::post('/updateDiscount/{id}', [CouponController::class, 'storeCoupon'])->name('updateDiscount');

        Route::get('/orderList',[OrderDetailsController::class, 'orderList'])->name('orderList');
        Route::get('/orderDetails',[OrderDetailsController::class, 'orderDetails'])->name('order.details');


    });
});

Route::get('/',[HomeController::class, 'home'])->name('home');
Route::get('/account/login',[UserAuthController::class,'getLogin'])->name('account.login');
Route::post('/account/login', [UserAuthController::class, 'authenticate'])->name('account.authenticate');
Route::get('/account/register',[UserAuthController::class,'getRegister'])->name('account.register');
Route::get('/account/dashboard',[UserAuthController::class, 'dashboard'])->name('account.dashboard');
Route::post('/account/processSignup', [UserAuthController::class, 'processSignUp'])->name('account.processSignup');
Route::get('/logout', [UserAuthController::class, 'logout'])->name('account.logout');


Route::post('/account/update-profile', [UserAuthController::class, 'updateProfile'])->name('account.updateProfile');
Route::post('/account/update-address', [UserAuthController::class, 'updateAddress'])->name('account.updateAddress');


Route::get('auth/google', [UserAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [UserAuthController::class, 'handleGoogleCallback']);


Route::get('auth/facebook', [UserAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [UserAuthController::class, 'handleFacebookCallback']);


Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::post('/add-to-cart',[CartController::class, 'addToCart'])->name('addToCart');
Route::post('/cart/remove',[CartController::class,'removeCart'])->name('cart.remove');
Route::post('/cart/update',[CartController::class,'updateCartQuantity'])->name('cart.updateQuantity');

Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
Route::post('/add-to-wishlist',[WishlistController::class, 'addToWishlist'])->name('addToWishlist');
Route::post('/removeFromWishlist',[WishlistController::class, 'removeFromWishlist'])->name('removeFromWishlist');

Route::get('/products',[ProductCategoryController::class, 'allProducts'])->name('products');
Route::get('/filter-products', [ProductCategoryController::class, 'filterProductsBySubcategory'])->name('filterProductsBySubcategory');
Route::get('/filter-products-by-brand', [ProductCategoryController::class, 'filterProductsByBrand'])->name('filterProductsByBrand');
Route::get('/filter-products-by-color', [ProductCategoryController::class, 'filterProductsByColor'])->name('filterProductsByColor');
Route::get('/filter-products-by-price', [ProductCategoryController::class, 'filterProductsByPrice'])->name('filterProductsByPrice');



Route::get('/product-details/{slug}', [ProductCategoryController::class, 'productDetails'])->name('productDetails');
Route::get('/checkout',[CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store', [CartController::class, 'checkoutStore'])->name('checkout.store');


Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::match(['get', 'post'], '/footwear_ecommerce/botman', [BotManController::class, 'handle']);

Route::post('/razorpay-initiate', [PaymentController::class, 'initiatePayment'])->name('razorpay-initiate');
Route::post('/razorpay-payment', [PaymentController::class, 'handlePayment'])->name('razorpay-payment');
Route::get('/order-success', function () {
    return view('order_success');
})->name('order.success');

Route::get('/order-failed', function () {
    return view('order_failed');
})->name('order.failed');


Route::get('/order-details/{order}', [OrderController::class, 'orderDetails'])->name('orderDetails');