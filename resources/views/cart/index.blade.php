@extends('layouts.store')

@section('title', 'Shopping Cart - ' . config('store.name'))

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-gray-500 mb-5">
        <a href="{{ route('home') }}" class="hover:text-brand transition-colors">Home</a>
        <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-ink font-medium">Shopping Cart</span>
    </nav>

    <div class="flex items-center gap-3 mb-8">
        <span class="w-11 h-11 rounded-xl brand-gradient-bg flex items-center justify-center border border-gold/40 shrink-0">
            <svg class="w-5 h-5 text-gold-light" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </span>
        <div>
            <h1 class="font-serif text-2xl font-bold text-ink">Your Shopping Cart</h1>
            <p class="text-xs text-gray-500 mt-0.5">
                {{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }} in your bag
            </p>
        </div>
    </div>

    @if($cartItems->count())
        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- ============ ITEMS ============ --}}
            <div class="flex-1 w-full space-y-4">

                @foreach($cartItems as $item)
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-gold/40 hover:shadow-card transition-all">

                        {{-- Thumbnail --}}
                        <div class="w-20 h-20 shrink-0 rounded-lg bg-white border border-gray-100 p-1.5 overflow-hidden">
                            @if($item->product && $item->product->thumbnail)
                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                     alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center rounded bg-gray-50">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>

                        {{-- Name + unit price --}}
                        <div class="flex-1 min-w-0">
                            @if($item->product)
                                <a href="{{ route('shop.show', $item->product->slug) }}"
                                   class="text-sm font-bold text-ink hover:text-brand transition-colors line-clamp-2">
                                    {{ $item->product->name }}
                                </a>
                                @if($item->product->category)
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $item->product->category->name }}</p>
                                @endif
                                <p class="text-sm text-brand font-bold mt-1">
                                    {{ config('store.currency') }} {{ number_format($item->product->current_price, 2) }}
                                </p>
                            @else
                                <span class="text-sm text-gray-400 italic">Product no longer available</span>
                            @endif
                        </div>

                        {{-- Quantity stepper --}}
                        <div class="flex items-center gap-4 sm:gap-5">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="flex items-center border border-gray-200 rounded-lg bg-white overflow-hidden">
                                    <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                            class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors" aria-label="Decrease quantity">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                    </button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                           class="w-12 text-center border-x border-gray-200 py-1.5 text-sm font-bold text-ink focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                            class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors" aria-label="Increase quantity">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                </div>
                            </form>

                            {{-- Line total --}}
                            <div class="text-right min-w-[6.5rem]">
                                <p class="text-[10px] uppercase tracking-wider text-gray-400">Total</p>
                                @if($item->product)
                                    <p class="text-sm font-black text-ink">
                                        {{ config('store.currency') }} {{ number_format($item->product->current_price * $item->quantity, 2) }}
                                    </p>
                                @endif
                            </div>

                            {{-- Remove --}}
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="p-2 rounded-full text-gray-400 hover:text-brand hover:bg-brand-50 transition-colors" title="Remove item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-ink hover:text-brand transition-colors pt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                    Continue Shopping
                </a>
            </div>

            {{-- ============ SUMMARY ============ --}}
            <div class="w-full lg:w-[22rem] shrink-0">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lux p-6 sticky top-28">
                    <h3 class="font-serif text-lg font-bold text-ink pb-4 border-b border-gray-100">Order Summary</h3>

                    <div class="space-y-3 text-sm py-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold text-ink">{{ config('store.currency') }} {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="font-semibold text-green-600">FREE</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <span class="text-sm font-semibold text-ink">Total</span>
                        <span class="font-serif font-bold text-xl text-brand">{{ config('store.currency') }} {{ number_format($subtotal, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="mt-6 w-full brand-gradient-bg text-white font-bold py-3.5 rounded-xl shadow-lg hover:brightness-110 transition-all flex items-center justify-center gap-2 border border-gold/30">
                        Proceed to Checkout
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>

                    <div class="mt-5 space-y-2.5 text-[11px] text-gray-500">
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Secure checkout
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Easy returns
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty state --}}
        <div class="text-center py-20 bg-gray-50 rounded-2xl border border-gray-100">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-5" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <h3 class="font-serif text-xl font-bold text-ink">Your cart is empty</h3>
            <p class="text-sm text-gray-500 mt-2">Browse the collection and add something you love.</p>
            <a href="{{ route('shop.index') }}"
               class="inline-flex items-center gap-2 mt-7 px-8 py-3.5 brand-gradient-bg text-white font-bold rounded-xl shadow-lg hover:brightness-110 transition-all border border-gold/30">
                Start Shopping
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    @endif
</div>

@endsection
