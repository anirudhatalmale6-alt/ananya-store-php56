@extends('layouts.store')

@section('title', 'Checkout - KitchenCraft & Brass')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-stone-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-700 transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('cart.index') }}" class="hover:text-amber-700 transition">Cart</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-stone-800 font-medium">Checkout</span>
    </nav>

    <h1 class="text-2xl font-bold text-stone-800 mb-8">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        {{ csrf_field() }}

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Shipping Information --}}
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <h2 class="text-lg font-semibold text-stone-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Shipping Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Full Name --}}
                        <div class="md:col-span-2">
                            <label for="shipping_name" class="block text-sm font-medium text-stone-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_name" id="shipping_name" value="{{ old('shipping_name', Auth::user()->name ?: '') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_name')) border-red-500 @endif">
                            @if($errors->has('shipping_name'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_name') }}</p>
                            @endif
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="shipping_email" class="block text-sm font-medium text-stone-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="shipping_email" id="shipping_email" value="{{ old('shipping_email', Auth::user()->email ?: '') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_email')) border-red-500 @endif">
                            @if($errors->has('shipping_email'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_email') }}</p>
                            @endif
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="shipping_phone" class="block text-sm font-medium text-stone-700 mb-1">Phone <span class="text-red-500">*</span></label>
                            <input type="tel" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', Auth::user()->phone ?: '') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_phone')) border-red-500 @endif">
                            @if($errors->has('shipping_phone'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_phone') }}</p>
                            @endif
                        </div>

                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label for="shipping_address" class="block text-sm font-medium text-stone-700 mb-1">Street Address <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address', Auth::user()->address ?: '') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_address')) border-red-500 @endif">
                            @if($errors->has('shipping_address'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_address') }}</p>
                            @endif
                        </div>

                        {{-- City --}}
                        <div>
                            <label for="shipping_city" class="block text-sm font-medium text-stone-700 mb-1">City <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', Auth::user()->city ?: '') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_city')) border-red-500 @endif">
                            @if($errors->has('shipping_city'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_city') }}</p>
                            @endif
                        </div>

                        {{-- State --}}
                        <div>
                            <label for="shipping_state" class="block text-sm font-medium text-stone-700 mb-1">State / Province <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_state" id="shipping_state" value="{{ old('shipping_state', Auth::user()->state ?: '') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_state')) border-red-500 @endif">
                            @if($errors->has('shipping_state'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_state') }}</p>
                            @endif
                        </div>

                        {{-- Zip --}}
                        <div>
                            <label for="shipping_zip" class="block text-sm font-medium text-stone-700 mb-1">ZIP / Postal Code <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_zip" id="shipping_zip" value="{{ old('shipping_zip', Auth::user()->zip ?: '') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_zip')) border-red-500 @endif">
                            @if($errors->has('shipping_zip'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_zip') }}</p>
                            @endif
                        </div>

                        {{-- Country --}}
                        <div>
                            <label for="shipping_country" class="block text-sm font-medium text-stone-700 mb-1">Country <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', Auth::user()->country ?: 'United States') }}" required
                                class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition @if($errors->has('shipping_country')) border-red-500 @endif">
                            @if($errors->has('shipping_country'))
                                <p class="text-red-600 text-xs mt-1">{{ $errors->first('shipping_country') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Order Notes --}}
                    <div class="mt-4">
                        <label for="notes" class="block text-sm font-medium text-stone-700 mb-1">Order Notes (optional)</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Any special instructions for your order..."
                            class="w-full px-4 py-2.5 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition resize-none">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-96 shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 sticky top-4">
                    <h2 class="text-lg font-semibold text-stone-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Order Summary
                    </h2>

                    {{-- Items --}}
                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @if(isset($cart))
                            @foreach($cart->cartItems as $item)
                                @if($item->product)
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 shrink-0 overflow-hidden rounded-lg bg-stone-100">
                                            @if($item->product->thumbnail)
                                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-100 to-stone-200">
                                                    <svg class="w-5 h-5 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-stone-800 truncate">{{ $item->product->name }}</p>
                                            <p class="text-xs text-stone-500">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <span class="text-sm font-medium text-stone-700">{{ config('store.currency') }} {{ number_format($item->product->current_price * $item->quantity, 2) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <hr class="border-stone-200 my-4">

                    {{-- Totals --}}
                    @php
                        $subtotal = 0;
                        if (isset($cart)) {
                            foreach ($cart->cartItems as $item) {
                                if ($item->product) {
                                    $subtotal += $item->product->current_price * $item->quantity;
                                }
                            }
                        }
                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $tax;
                    @endphp

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-stone-600">
                            <span>Subtotal</span>
                            <span class="font-medium">{{ config('store.currency') }} {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-stone-600">
                            <span>Tax (10%)</span>
                            <span class="font-medium">{{ config('store.currency') }} {{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-stone-600">
                            <span>Shipping</span>
                            <span class="font-medium text-green-600">Free</span>
                        </div>
                        <hr class="border-stone-200">
                        <div class="flex justify-between text-stone-800 pt-1">
                            <span class="text-base font-semibold">Total</span>
                            <span class="text-xl font-bold text-amber-700">{{ config('store.currency') }} {{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="mt-6 w-full py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Place Order
                    </button>

                    <p class="text-xs text-stone-400 text-center mt-3">Your personal data will be used to process your order.</p>

                    <a href="{{ route('cart.index') }}" class="block text-center text-sm text-amber-700 hover:text-amber-800 font-medium mt-4 transition">
                        Return to Cart
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
