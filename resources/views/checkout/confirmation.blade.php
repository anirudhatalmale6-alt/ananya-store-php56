@extends('layouts.store')

@section('title', 'Order Confirmed - KitchenCraft & Brass')

@section('content')

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Success Header --}}
    <div class="text-center mb-10">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-ink">Order Confirmed!</h1>
        <p class="text-gray-500 mt-2">Thank you for your purchase. Your order has been placed successfully.</p>
    </div>

    {{-- Order Details --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- Order Header --}}
        <div class="bg-brand-50 border-b border-brand-100 px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <p class="text-sm text-gray-500">Order Number</p>
                    <p class="text-lg font-bold text-brand-dark">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Order Date</p>
                    <p class="text-sm font-medium text-ink">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="px-6 py-4">
            <h3 class="text-sm font-semibold text-ink uppercase tracking-wider mb-3">Items Ordered</h3>

            <div class="space-y-3">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center gap-4 py-2">
                        <div class="w-14 h-14 shrink-0 overflow-hidden rounded-lg bg-gray-100">
                            @if($item->product && $item->product->thumbnail)
                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-ink">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} x {{ config('store.currency') }} {{ number_format($item->price, 2) }}</p>
                        </div>
                        <span class="text-sm font-semibold text-ink">{{ config('store.currency') }} {{ number_format($item->total, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Order Totals --}}
        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
            <div class="space-y-2 text-sm max-w-xs ml-auto">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>{{ config('store.currency') }} {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Tax</span>
                    <span>{{ config('store.currency') }} {{ number_format($order->tax, 2) }}</span>
                </div>
                @if($order->shipping_cost > 0)
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>{{ config('store.currency') }} {{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                @endif
                <hr class="border-gray-200">
                <div class="flex justify-between text-ink font-bold text-base pt-1">
                    <span>Total</span>
                    <span class="text-brand">{{ config('store.currency') }} {{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping Info --}}
        <div class="border-t border-gray-200 px-6 py-4">
            <h3 class="text-sm font-semibold text-ink uppercase tracking-wider mb-2">Shipping Address</h3>
            <div class="text-sm text-gray-600 leading-relaxed">
                <p class="font-medium text-ink">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                <p>{{ $order->shipping_country }}</p>
                @if($order->shipping_phone)
                    <p class="mt-1">Phone: {{ $order->shipping_phone }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-8 py-3 brand-gradient-bg hover:brightness-110 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
            Continue Shopping
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center px-8 py-3 border-2 border-gray-300 text-ink hover:border-brand hover:text-brand font-semibold rounded-lg transition-all duration-300">
            View My Orders
        </a>
    </div>
</div>

@endsection
