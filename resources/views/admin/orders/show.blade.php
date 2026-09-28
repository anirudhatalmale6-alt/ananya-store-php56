@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Order {{ $order->order_number }}</h2>
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-surface-alt transition-colors">
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Info & Status Update --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Order Information</h3>
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col sm:flex-row sm:items-start gap-2">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <select name="status"
                                        class="rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm">
                                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-2 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors">
                                    Update
                                </button>
                            </div>
                            <input type="text" name="note" maxlength="1000" placeholder="Optional remark (e.g. courier + tracking #) — included in the email"
                                   class="rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-xs w-full sm:w-80">
                        </div>
                    </form>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Order Number</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $order->order_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
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
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                        <dd class="mt-1">
                            @php
                                $paymentColors = [
                                    'paid' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                    'refunded' => 'bg-white text-gray-800',
                                ];
                            @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($paymentColors[$order->payment_status]) ? $paymentColors[$order->payment_status] : 'bg-white text-gray-800' }}">
                                {{ ucfirst($order->payment_status ?: 'N/A') }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_method ?: 'N/A') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Order Items --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Order Items</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-surface-alt">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($item->product && $item->product->thumbnail)
                                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="" class="w-10 h-10 rounded-lg object-cover mr-3">
                                            @endif
                                            <span class="font-medium text-gray-900">{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ config('store.currency') }} {{ number_format($item->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ config('store.currency') }} {{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Order Totals --}}
                <div class="border-t border-gray-200 px-6 py-4">
                    <div class="flex flex-col items-end space-y-2">
                        <div class="flex justify-between w-full max-w-xs text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="text-gray-900">{{ config('store.currency') }} {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between w-full max-w-xs text-sm">
                            <span class="text-gray-500">Tax</span>
                            <span class="text-gray-900">{{ config('store.currency') }} {{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between w-full max-w-xs text-sm">
                            <span class="text-gray-500">Shipping</span>
                            <span class="text-gray-900">{{ config('store.currency') }} {{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="flex justify-between w-full max-w-xs text-sm font-bold border-t border-gray-200 pt-2">
                            <span class="text-gray-900">Total</span>
                            <span class="text-gray-900">{{ config('store.currency') }} {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($order->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Order Notes</h3>
                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Customer Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Customer</h3>
                @if($order->user)
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                        @if($order->user->phone)
                            <p class="text-sm text-gray-600">{{ $order->user->phone }}</p>
                        @endif
                        <a href="{{ route('admin.customers.show', $order->user) }}" class="inline-block mt-2 text-sm text-brand hover:text-brand font-medium">
                            View Customer Profile
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-500">Guest order</p>
                @endif
            </div>

            {{-- Shipping Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Shipping Address</h3>
                <div class="text-sm text-gray-700 space-y-1">
                    <p class="font-medium">{{ $order->shipping_name }}</p>
                    @if($order->shipping_email)
                        <p>{{ $order->shipping_email }}</p>
                    @endif
                    @if($order->shipping_phone)
                        <p>{{ $order->shipping_phone }}</p>
                    @endif
                    @if($order->shipping_address)
                        <p>{{ $order->shipping_address }}</p>
                    @endif
                    <p>
                        {{ collect([$order->shipping_city, $order->shipping_state, $order->shipping_zip])->filter()->implode(', ') }}
                    </p>
                    @if($order->shipping_country)
                        <p>{{ $order->shipping_country }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
