<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product->current_price * $item->quantity);

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return back()->with('success', "{$product->name} added to cart!");
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        CartItem::where('user_id', auth()->id())->delete();
        return back()->with('success', 'Cart cleared.');
    }
}