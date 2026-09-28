@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Product Details</h2>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.products.edit', $product) }}"
               class="inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-surface-alt transition-colors">
                Back to Products
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Images Gallery --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Images</h3>

                {{-- Thumbnail --}}
                @if($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                         class="w-full rounded-lg object-cover mb-4">
                @else
                    <div class="w-full aspect-square rounded-lg bg-white flex items-center justify-center mb-4">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                {{-- Additional Images --}}
                @if($product->productImages->count() > 0)
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($product->productImages as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product image"
                                 class="w-full aspect-square rounded-lg object-cover">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Product Information</h3>

                <div class="flex items-center space-x-3 mb-4">
                    @if($product->is_active)
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-gray-800">Inactive</span>
                    @endif
                    @if($product->is_featured)
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Featured</span>
                    @endif
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $product->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Category</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->category ? $product->category->name : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">SKU</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->sku ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Price</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ config('store.currency') }} {{ number_format($product->price, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sale Price</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($product->sale_price)
                                <span class="text-red-600 font-medium">{{ config('store.currency') }} {{ number_format($product->sale_price, 2) }}</span>
                            @else
                                -
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Stock</dt>
                        <dd class="mt-1 text-sm {{ $product->stock < 10 ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                            {{ $product->stock }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Weight</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $product->weight ? $product->weight . ' kg' : '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Short Description --}}
            @if($product->short_description)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Short Description</h3>
                    <p class="text-sm text-gray-700">{{ $product->short_description }}</p>
                </div>
            @endif

            {{-- Full Description --}}
            @if($product->description)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Description</h3>
                    <div class="text-sm text-gray-700 prose max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
