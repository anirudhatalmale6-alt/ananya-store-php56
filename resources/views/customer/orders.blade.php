@extends('layouts.store')

@section('title', 'My Orders - KitchenCraft & Brass')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('customer.dashboard') }}" class="hover:text-brand transition">My Account</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-ink font-medium">My Orders</span>
    </nav>

    <h1 class="text-2xl font-bold text-ink mb-8">My Orders</h1>

    @if($orders->count())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order Number</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-ink">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y') }}</span>
                                    <br>
                                    <span class="text-xs text-gray-400">{{ $order->created_at->format('g:i A') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-600">{{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-purple-100 text-purple-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = isset($statusColors[$order->status]) ? $statusColors[$order->status] : 'bg-gray-100 text-ink';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $color }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-ink">{{ config('store.currency') }} {{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('customer.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-50 text-brand hover:bg-brand-100 text-sm font-medium rounded-lg transition">
                                        View
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="text-xl font-semibold text-ink">No orders yet</h3>
            <p class="text-gray-500 mt-2">You haven't placed any orders yet. Start shopping to see your orders here.</p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center mt-6 px-8 py-3 brand-gradient-bg hover:brightness-110 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                Start Shopping
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    @endif
</div>

@endsection
