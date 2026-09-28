@extends('layouts.store')

@section('title', 'Shopping Cart - KitchenCraft & Brass')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-stone-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-700 transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-stone-800 font-medium">Shopping Cart</span>
    </nav>

    <h1 class="text-2xl font-bold text-stone-800 mb-8">Shopping Cart</h1>

    @if(isset($cart) && $cart->cartItems->count())
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Cart Items --}}
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">

                    {{-- Header (Desktop) --}}
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-stone-50 border-b border-stone-200 text-xs font-semibold text-stone-500 uppercase tracking-wider">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-1 text-right">Total</div>
                        <div class="col-span-1"></div>
                    </div>

                    {{-- Cart Items --}}
                    @foreach($cart->cartItems as $item)
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-6 py-4 border-b border-stone-100 items-center">

                            {{-- Product Info --}}
                            <div class="md:col-span-6 flex items-center gap-4">
                                <div class="w-20 h-20 shrink-0 overflow-hidden rounded-lg bg-stone-100">
                                    @if($item->product && $item->product->thumbnail)
                                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product ? $item->product->name : 'Product' }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-100 to-stone-200">
                                            <svg class="w-8 h-8 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    @if($item->product)
                                        <a href="{{ route('shop.show', $item->product->slug) }}" class="text-sm font-semibold text-stone-800 hover:text-amber-700 transition">
                                            {{ $item->product->name }}
                                        </a>
                                        @if($item->product->category)
                                            <p class="text-xs text-stone-400 mt-0.5">{{ $item->product->category->name }}</p>
                                        @endif
                                    @else
                                        <span class="text-sm text-stone-400 italic">Product unavailable</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Unit Price --}}
                            <div class="md:col-span-2 text-center">
                                <span class="md:hidden text-xs text-stone-500 font-medium">Price: </span>
                                @if($item->product)
                                    <span class="text-sm font-medium text-stone-700">{{ config('store.currency') }} {{ number_format($item->product->current_price, 2) }}</span>
                                @endif
                            </div>

                            {{-- Quantity --}}
                            <div class="md:col-span-2 flex justify-center">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-1">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="flex items-center border border-stone-300 rounded-lg overflow-hidden">
                                        <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="px-2 py-1.5 bg-stone-50 hover:bg-stone-100 text-stone-600 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-12 text-center border-x border-stone-300 py-1.5 text-sm focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-2 py-1.5 bg-stone-50 hover:bg-stone-100 text-stone-600 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Line Total --}}
                            <div class="md:col-span-1 text-right">
                                <span class="md:hidden text-xs text-stone-500 font-medium">Total: </span>
                                @if($item->product)
                                    <span class="text-sm font-bold text-stone-800">{{ config('store.currency') }} {{ number_format($item->product->current_price * $item->quantity, 2) }}</span>
                                @endif
                            </div>

                            {{-- Remove --}}
                            <div class="md:col-span-1 text-right">
                                <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="text-stone-400 hover:text-red-600 transition" title="Remove item">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Continue Shopping --}}
                <div class="mt-4">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center text-amber-700 hover:text-amber-800 font-medium transition text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            {{-- Cart Summary --}}
            <div class="lg:w-80 shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-stone-800 mb-4">Order Summary</h3>

                    @php
                        $subtotal = 0;
                        foreach ($cart->cartItems as $item) {
                            if ($item->product) {
                                $subtotal += $item->product->current_price * $item->quantity;
                            }
                        }
                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $tax;
                    @endphp

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-stone-600">
                            <span>Subtotal</span>
                            <span class="font-medium">{{ config('store.currency') }} {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-stone-600">
                            <span>Estimated Tax (10%)</span>
                            <span class="font-medium">{{ config('store.currency') }} {{ number_format($tax, 2) }}</span>
                        </div>
                        <hr class="border-stone-200">
                        <div class="flex justify-between text-stone-800">
                            <span class="text-base font-semibold">Total</span>
                            <span class="text-base font-bold">{{ config('store.currency') }} {{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="mt-6 w-full inline-flex items-center justify-center py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                        Proceed to Checkout
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Empty Cart --}}
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-stone-200">
            <svg class="w-20 h-20 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
            </svg>
            <h3 class="text-xl font-semibold text-stone-800">Your cart is empty</h3>
            <p class="text-stone-500 mt-2">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center mt-6 px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                Start Shopping
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    @endif
</div>

@endsection
