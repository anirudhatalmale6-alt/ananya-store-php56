@extends('layouts.admin')

@section('title', 'Customer: ' . $customer->name)

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Customer Details</h2>
        <a href="{{ route('admin.customers.index') }}"
           class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-surface-alt transition-colors">
            Back to Customers
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Customer Info --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-brand">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $customer->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                </div>

                <dl class="space-y-4">
                    @if($customer->phone)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->phone }}</dd>
                        </div>
                    @endif

                    @if($customer->address)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $customer->address }}<br>
                                {{ collect([$customer->city, $customer->state, $customer->zip])->filter()->implode(', ') }}
                                @if($customer->country)
                                    <br>{{ $customer->country }}
                                @endif
                            </dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Joined</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $customer->created_at->format('F d, Y') }}</dd>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <dt class="text-xs font-medium text-gray-500 uppercase">Total Spent</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">{{ config('store.currency') }} {{ number_format($totalSpent, 2) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Order History --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                        Order History ({{ $customer->orders->count() }})
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-surface-alt">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($customer->orders as $order)
                                <tr class="hover:bg-surface-alt">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'shipped' => 'bg-purple-100 text-purple-800',
                                                'delivered' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($statusColors[$order->status]) ? $statusColors[$order->status] : 'bg-white text-gray-800' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ config('store.currency') }} {{ number_format($order->total, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-brand hover:text-brand font-medium">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
