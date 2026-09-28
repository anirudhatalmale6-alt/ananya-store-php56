<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Note: Request::filled() arrived in Laravel 5.5. In 5.4, has() already
        // returns false for an empty string, so it is the exact equivalent.
        $query = Product::active()->with('category');

        if ($request->has('category')) {
            $slug = $request->input('category');
            $query->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        // Price range filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends($request->query());

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with(array('category', 'productImages'))
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::active()
            ->where('category_id', $category->id)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('shop.index', compact('products', 'categories', 'category'));
    }
}
