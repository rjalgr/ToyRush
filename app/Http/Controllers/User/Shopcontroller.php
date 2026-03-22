<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featured   = Product::active()->featured()->with('category')->take(8)->get();
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $newArrivals = Product::active()->with('category')->latest()->take(8)->get();

        return view('user.home', compact('featured', 'categories', 'newArrivals'));
    }

    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }

        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->age) {
            $query->where('age_min', '<=', $request->age)
                  ->where('age_max', '>=', $request->age);
        }

        $sort = $request->sort ?? 'latest';
        match($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name'       => $query->orderBy('name'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('user.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);
        $product->load('category');

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('user.products.show', compact('product', 'related'));
    }
}