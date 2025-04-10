<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ColorCode;
use App\Models\DiscountCoupon;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function allProducts(Request $request){
        $categories = Category::where('status', 'Active')
        ->with(['subcategories' => function ($query) {
            $query->where('status', 'Active')->with('viewCategory');
        }])->get();

        $brands = Brand::where('status','Active')->get();

        $products = Product::where('status','Active')->paginate(9);

        if($request->ajax()) {
            return response()->json([
                'products' => view('partial-product-list', compact('products'))->render(),
                'pagination' => view('partial-product-pagination', compact('products'))->render()
            ]);
        }

        $colors = ColorCode::where('status','Active')->get();
        $deals = DiscountCoupon::where('deal_of_week', 1)->with('product.firstImage')->get();
        return view('products',compact('products','categories','brands','colors','deals'));
    }


    public function productDetails($slug)
    {
        try {
            $product = Product::where('slug', $slug)
                ->with(['images', 'categoryName']) // Fetch category relation
                ->firstOrFail();
                $deals = DiscountCoupon::where('deal_of_week', 1)->with('product.firstImage')->get();
            return view('productDetails', compact('product','deals'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Product not found: ' . $e->getMessage()]);
        }
    }

    public function filterProductsBySubcategory(Request $request)
    {
        // dd($request->all());
        // die();
        $subcategoryId = $request->subcategory;
        $products = Product::where('subcategory', $subcategoryId)->get();

        $html = '';
        if ($products->count() > 0) {
            foreach ($products as $item) {
                $html .= '<div class="col-lg-4 col-md-6">
                            <div class="single-product">
                                <a href="'.route('productDetails', ['slug' => $item->slug]).'">
                                    <img class="img-fluid" src="'.url('public/product_images/' . ($item->images->first()->images ?? 'default.png')).'" alt="'.$item->slug.'">
                                </a>
                                <div class="product-details">
                                    <h6>'.$item->title.'</h6>
                                    <div class="price">
                                        <h6>₹'.$item->new_price.'</h6>
                                        <h6 class="l-through">₹'.$item->old_price.'</h6>
                                    </div>
                                    <div class="prd-bottom">
                                        <a href="javascript:void(0)" data-id="'.$item->id.'" class="social-info add-to-cart">
                                            <span class="ti-bag"></span>
                                            <p class="hover-text">add to bag</p>
                                        </a>
                                        <a href="javascript:void(0)" data-id="'.$item->id.'" class="social-info add-to-wishlist">
                                            <span class="lnr lnr-heart"></span>
                                            <p class="hover-text">Wishlist</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        } else {
            $html = '<p class="text-center w-100">No Product found</p>';
        }

        return response()->json($html);
    }

    public function filterProductsByBrand(Request $request){
        $brandId = $request->brand;
        $products = Product::where('brand', $brandId)->get();

        return view('filtered_products', compact('products'))->render();
    }

    public function filterProductsByColor(Request $request)
    {
        $colorId = $request->color_id;
    
        $color = ColorCode::find($colorId);
    
        if (!$color) {
            return response()->json(['error' => 'Color not found'], 404);
        }
    
        $products = Product::where('colors', $colorId)->get();
    
        return view('filtered_products', compact('products'))->render();
    }
    

    public function filterProductsByPrice(Request $request)
    {
        $minPrice = (float) $request->min_price;
        $maxPrice = (float) $request->max_price;
    
        $products = Product::all()->filter(function ($product) use ($minPrice, $maxPrice) {
            $numericPrice = (float) str_replace(',', '', $product->new_price);
    
            return $numericPrice >= $minPrice && $numericPrice <= $maxPrice;
        });
    
        return view('filtered_products', compact('products'))->render();
    }

    
    

    
}