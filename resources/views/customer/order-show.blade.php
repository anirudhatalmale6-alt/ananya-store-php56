@extends('layouts.store')

@section('title', 'Order ' . $order->order_number . ' - KitchenCraft & Brass')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-stone-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-700 transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('customer.dashboard') }}" class="hover:text-amber-700 transition">My Account</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('customer.orders') }}" class="hover:text-amber-700 transition">My Orders</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-stone-800 font-medium">{{ $order->order_number }}</span>
    </nav>

    {{-- Order Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-stone-800">Order {{ $order->order_number }}</h1>
            <p class="text-stone-500 text-sm mt-1">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center text-amber-700 hover:text-amber-800 font-medium text-sm transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Back to Orders
        </a>
    </div>

    {{-- Status & Payment Info --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $statusColors = [
                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                'delivered' => 'bg-green-100 text-green-800 border-green-200',
                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
            ];
            $statusColor = isset($statusColors[$order->status]) ? $statusColors[$order->status] : 'bg-stone-100 text-stone-800 border-stone-200';

            $paymentColors = [
                'paid' => 'bg-green-100 text-green-800 border-green-200',
                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'failed' => 'bg-red-100 text-red-800 border-red-200',
                'refunded' => 'bg-purple-100 text-purple-800 border-purple-200',
            ];
            $paymentColor = isset($paymentColors[$order->payment_status]) ? $paymentColors[$order->payment_status] : 'bg-stone-100 text-stone-800 border-stone-200';
        @endphp

        <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-4">
            <p class="text-xs text-stone-500 font-medium uppercase tracking-wider">Order Status</p>
            <span class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-4">
            <p class="text-xs text-stone-500 font-medium uppercase tracking-wider">Payment Status</p>
            <span class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-sm font-semibold {{ $paymentColor }}">
                {{ ucfirst($order->payment_status ?: 'Pending') }}
            </span>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-4">
            <p class="text-xs text-stone-500 font-medium uppercase tracking-wider">Payment Method</p>
            <p class="text-sm font-medium text-stone-800 mt-1">{{ ucfirst($order->payment_method ?: 'N/A') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-4">
            <p class="text-xs text-stone-500 font-medium uppercase tracking-wider">Order Total</p>
            <p class="text-xl font-bold text-amber-700 mt-1">{{ config('store.currency') }} {{ number_format($order->total, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Order Items --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-stone-200">
                    <h2 class="text-lg font-semibold text-stone-800">Order Items</h2>
                </div>

                <div class="divide-y divide-stone-100">
                    @foreach($order->orderItems as $item)
                        <div class="px-6 py-4 flex items-center gap-4">
                            <div class="w-16 h-16 shrink-0 overflow-hidden rounded-lg bg-stone-100">
                                @if($item->product && $item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-100 to-stone-200">
                                        <svg class="w-6 h-6 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-stone-800">{{ $item->product_name }}</p>
                                <p class="text-xs text-stone-500 mt-0.5">
                                    {{ config('store.currency') }} {{ number_format($item->price, 2) }} x {{ $item->quantity }}
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-stone-800">{{ config('store.currency') }} {{ number_format($item->total, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Totals --}}
                <div class="bg-stone-50 border-t border-stone-200 px-6 py-4">
                    <div class="space-y-2 text-sm max-w-xs ml-auto">
                        <div class="flex justify-between text-stone-600">
                            <span>Subtotal</span>
                            <span>{{ config('store.currency') }} {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-stone-600">
                            <span>Tax</span>
                            <span>{{ config('store.currency') }} {{ number_format($order->tax, 2) }}</span>
                        </div>
                        @if($order->shipping_cost > 0)
                            <div class="flex justify-between text-stone-600">
                                <span>Shipping</span>
                                <span>{{ config('store.currency') }} {{ number_format($order->shipping_cost, 2) }}</span>
                            </div>
                        @endif
                        <hr class="border-stone-200">
                        <div class="flex justify-between font-bold text-base text-stone-800 pt-1">
                            <span>Total</span>
                            <span class="text-amber-700">{{ config('store.currency') }} {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping Information --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <h2 class="text-lg font-semibold text-stone-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Shipping Address
                </h2>
                <div class="text-sm text-stone-600 leading-relaxed space-y-1">
                    <p class="font-semibold text-stone-800">{{ $order->shipping_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                    <p>{{ $order->shipping_country }}</p>
                    @if($order->shipping_phone)
                        <p class="pt-2">
                            <span class="text-stone-500">Phone:</span> {{ $order->shipping_phone }}
                        </p>
                    @endif
                    @if($order->shipping_email)
                        <p>
                            <span class="text-stone-500">Email:</span> {{ $order->shipping_email }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Notes --}}
            @if($order->notes)
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 mt-4">
                    <h3 class="text-sm font-semibold text-stone-800 mb-2">Order Notes</h3>
                    <p class="text-sm text-stone-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
