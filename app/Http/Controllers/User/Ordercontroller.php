<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($i) => $i->product->current_price * $i->quantity);
        $shipping = $subtotal >= 1000 ? 0 : 150;
        $tax      = round($subtotal * 0.12, 2);
        $total    = $subtotal + $shipping + $tax;

        return view('user.orders.checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_email'   => 'required|email',
            'shipping_phone'   => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string',
            'shipping_state'   => 'nullable|string',
            'shipping_zip'     => 'nullable|string',
            'payment_method'   => 'required|in:cod,gcash,card',
            'notes'            => 'nullable|string',
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        // Validate stock
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "{$item->product->name} does not have enough stock.");
            }
        }

        $subtotal = $cartItems->sum(fn($i) => $i->product->current_price * $i->quantity);
        $shipping = $subtotal >= 1000 ? 0 : 150;
        $tax      = round($subtotal * 0.12, 2);
        $total    = $subtotal + $shipping + $tax;

        DB::transaction(function () use ($data, $cartItems, $subtotal, $shipping, $tax, $total) {
            $order = Order::create(array_merge($data, [
                'user_id'          => auth()->id(),
                'subtotal'         => $subtotal,
                'shipping'         => $shipping,
                'tax'              => $tax,
                'total'            => $total,
                'shipping_country' => 'Philippines',
            ]));

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $item->product->current_price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->product->current_price * $item->quantity,
                ]);

                // Decrement stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            CartItem::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('user.orders.index')->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function profile()
{
    $user = auth()->user();
    $recentOrders = Order::where('user_id', $user->id)
        ->with('items')
        ->latest()
        ->take(5)
        ->get();

    return view('user.profile', compact('user', 'recentOrders'));
}

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('user.orders.show', compact('order'));
    }
}