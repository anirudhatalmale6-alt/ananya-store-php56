<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Services\OrderMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('cartItems.product')
            ->first();

        if (! $cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $cartItems = $cart->cartItems;

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->current_price * $item->quantity;
        }

        return view('checkout.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'shipping_name'    => 'required|string|max:255',
            'shipping_email'   => 'required|email|max:255',
            'shipping_phone'   => 'required|string|max:50',
            'shipping_address' => 'required|string|max:500',
            'shipping_city'    => 'required|string|max:255',
            'shipping_state'   => 'required|string|max:255',
            'shipping_zip'     => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            'payment_method'   => 'nullable|string|max:50',
            'notes'            => 'nullable|string|max:1000',
        ));

        $cart = Cart::where('user_id', auth()->id())
            ->with('cartItems.product')
            ->first();

        if (! $cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $paymentMethod = $request->input('payment_method');
        if ($paymentMethod === null || $paymentMethod === '') {
            $paymentMethod = 'cod';
        }

        $order = DB::transaction(function () use ($request, $cart, $paymentMethod) {
            $cartItems = $cart->cartItems;

            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item->product->current_price * $item->quantity;
            }

            $tax = round($subtotal * 0.00, 2); // Tax rate can be configured later
            $shippingCost = 0.00;              // Shipping logic can be added later
            $total = $subtotal + $tax + $shippingCost;

            $order = Order::create(array(
                'user_id'          => auth()->id(),
                'status'           => 'pending',
                'subtotal'         => $subtotal,
                'tax'              => $tax,
                'shipping_cost'    => $shippingCost,
                'total'            => $total,
                'shipping_name'    => $request->input('shipping_name'),
                'shipping_email'   => $request->input('shipping_email'),
                'shipping_phone'   => $request->input('shipping_phone'),
                'shipping_address' => $request->input('shipping_address'),
                'shipping_city'    => $request->input('shipping_city'),
                'shipping_state'   => $request->input('shipping_state'),
                'shipping_zip'     => $request->input('shipping_zip'),
                'shipping_country' => $request->input('shipping_country'),
                'payment_method'   => $paymentMethod,
                'payment_status'   => 'unpaid',
                'notes'            => $request->input('notes'),
            ));

            foreach ($cartItems as $item) {
                $order->orderItems()->create(array(
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity'     => $item->quantity,
                    'price'        => $item->product->current_price,
                    'total'        => $item->product->current_price * $item->quantity,
                ));

                // Decrement product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear the cart
            $cart->cartItems()->delete();
            $cart->delete();

            return $order;
        });

        // Fire order-confirmation emails to the customer and the administrator
        // (native PHP mail — failures are logged, never block the checkout).
        app('App\Services\OrderMailer')->orderPlaced($order);

        return redirect()->route('checkout.confirmation', $order->id)
            ->with('success', 'Order placed successfully! A confirmation email is on its way.');
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('checkout.confirmation', compact('order'));
    }
}
