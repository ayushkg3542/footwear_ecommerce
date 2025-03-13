<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ColorCode;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function allProducts(){
        $categories = Category::where('status', 'Active')
        ->with(['subcategories' => function ($query) {
            $query->where('status', 'Active')->with('viewCategory');
        }])->get();

        $brands = Brand::where('status','Active')->get();

        $products = Product::where('status','Active')->get();

        $colors = ColorCode::where('status','Active')->get();
        return view('products',compact('products','categories','brands','colors'));
    }


    public function productDetails($slug)
    {
        try {
            $product = Product::where('slug', $slug)
                ->with(['images', 'categoryName']) // Fetch category relation
                ->firstOrFail();
            return view('productDetails', compact('product'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Product not found: ' . $e->getMessage()]);
        }
    }
    
}