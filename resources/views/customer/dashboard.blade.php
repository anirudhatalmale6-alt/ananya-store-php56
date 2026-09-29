@extends('layouts.store')

@section('title', 'My Account - KitchenCraft & Brass')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-ink font-medium">My Account</span>
    </nav>

    {{-- Welcome Message --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-ink">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-500 mt-1">Manage your orders and account details from your dashboard.</p>
    </div>

    {{-- Quick Links --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center px-4 py-2 bg-brand-50 text-brand rounded-lg hover:bg-brand-100 transition text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            All Orders
        </a>
        <a href="{{ route('customer.profile') }}" class="inline-flex items-center px-4 py-2 bg-brand-50 text-brand rounded-lg hover:bg-brand-100 transition text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Edit Profile
        </a>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-50 text-brand rounded-lg hover:bg-brand-100 transition text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Continue Shopping
        </a>
    </div>

    {{-- Stats Cards --}}
    @php
        $totalOrders = Auth::user()->orders;
        $pendingOrders = $totalOrders->whereIn('status', ['pending', 'processing']);
        $deliveredOrders = $totalOrders->where('status', 'delivered');
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-10">
        {{-- Total Orders --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Orders</p>
                    <p class="text-3xl font-bold text-ink mt-1">{{ $totalOrders->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending Orders</p>
                    <p class="text-3xl font-bold text-brand mt-1">{{ $pendingOrders->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Delivered Orders --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Delivered Orders</p>
                    <p class="text-3xl font-bold text-green-700 mt-1">{{ $deliveredOrders->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-ink">Recent Orders</h2>
            <a href="{{ route('customer.orders') }}" class="text-sm text-brand hover:text-brand-dark font-medium transition">View All</a>
        </div>

        @php
            $recentOrders = $totalOrders->sortByDesc('created_at')->take(5);
        @endphp

        @if($recentOrders->count())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-ink">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M j, Y') }}</td>
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
                                <td class="px-6 py-4 text-sm font-semibold text-ink text-right">{{ config('store.currency') }} {{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('customer.orders.show', $order) }}" class="text-brand hover:text-brand-dark text-sm font-medium transition">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-gray-500">No orders yet.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center mt-3 text-brand hover:text-brand-dark font-medium text-sm transition">
                    Start Shopping
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
