<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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


    });
});

Route::get('/',[HomeController::class, 'home'])->name('home');