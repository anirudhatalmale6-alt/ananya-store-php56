@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Customers</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-surface-alt">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Spent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-surface-alt">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $customer->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $customer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $customer->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $customer->orders_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ config('store.currency') }} {{ number_format($customer->orders_sum_total ?: 0, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $customer->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="text-brand hover:text-brand font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
@endsection
