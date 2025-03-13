<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $allProduct = Product::where('status','Active')->get();
        $categories = Category::where('status','Active')->latest()->take(5)->get();
        return view('home', compact('allProduct','categories'));
    }

    public function products(Request $request){
        $query = Product::query();

        if($request->has('search')&& !empty($request->search)){
            $searchTerm = $request->search;
            $query->where('title','LIKE',"%{$searchTerm}%")
            ->orWhere('description','LIKE',"%{$searchTerm}%");
        }

        $products = $query->get();
        return view('products', compact('products'));
    }
}

// 
