<?php

namespace App\View\Composers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class StoreComposer
{
    /**
     * Share the category nav and the cart badge count with the store layout.
     *
     * @param  \Illuminate\Contracts\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navCategories', Category::where('is_active', true)->orderBy('sort_order')->get());

        $cartCount = 0;

        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
        } else {
            $cart = Cart::where('session_id', session()->getId())->first();
        }

        if ($cart) {
            $cartCount = $cart->cartItems()->sum('quantity');
        }

        $view->with('cartItemCount', $cartCount);
    }
}
