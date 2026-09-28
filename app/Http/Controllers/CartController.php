<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();

        if ($cart) {
            $cartItems = $cart->cartItems()->with('product.category')->get();
        } else {
            $cartItems = collect();
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $subtotal += $item->product->current_price * $item->quantity;
            }
        }

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $this->validate($request, array(
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ));

        $product = Product::active()->findOrFail($request->input('product_id'));
        $cart = $this->getCart(true);

        $cartItem = $cart->cartItems()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->update(array(
                'quantity' => $cartItem->quantity + $request->input('quantity'),
            ));
        } else {
            $cart->cartItems()->create(array(
                'product_id' => $product->id,
                'quantity'   => $request->input('quantity'),
            ));
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->validate($request, array(
            'quantity' => 'required|integer|min:1',
        ));

        $cart = $this->getCart();

        if (! $cart || $cartItem->cart_id !== $cart->id) {
            abort(403);
        }

        $cartItem->update(array(
            'quantity' => $request->input('quantity'),
        ));

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $cart = $this->getCart();

        if (! $cart || $cartItem->cart_id !== $cart->id) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    /**
     * Get or create a cart based on authentication state.
     *
     * @param  bool $create
     * @return \App\Models\Cart|null
     */
    protected function getCart($create = false)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();

            if (! $cart && $create) {
                // Check for a guest cart to migrate
                $sessionCart = Cart::where('session_id', session()->getId())
                    ->whereNull('user_id')
                    ->first();

                if ($sessionCart) {
                    $sessionCart->update(array('user_id' => auth()->id(), 'session_id' => null));
                    return $sessionCart;
                }

                $cart = Cart::create(array('user_id' => auth()->id()));
            }

            return $cart;
        }

        $cart = Cart::where('session_id', session()->getId())->first();

        if (! $cart && $create) {
            $cart = Cart::create(array('session_id' => session()->getId()));
        }

        return $cart;
    }
}
