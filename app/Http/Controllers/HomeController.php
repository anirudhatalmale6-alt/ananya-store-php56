<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()
            ->featured()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $latestProducts = Product::active()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}
