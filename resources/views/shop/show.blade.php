@extends('layouts.store')

@section('title', $product->name . ' - KitchenCraft & Brass')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('shop.index') }}" class="hover:text-brand transition">Shop</a>
        @if($product->category)
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-brand transition">{{ $product->category->name }}</a>
        @endif
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-ink font-medium truncate">{{ $product->name }}</span>
    </nav>

    {{-- Product Detail --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

        {{-- Image Gallery --}}
        <div>
            {{-- Main Image --}}
            <div class="aspect-square overflow-hidden rounded-xl bg-gray-100 border border-gray-200 mb-4" id="main-image-container">
                @if($product->thumbnail)
                    <img id="main-image" src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div id="main-image" class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Thumbnail Gallery --}}
            @if($product->productImages->count())
                <div class="grid grid-cols-5 gap-2">
                    {{-- Thumbnail for main image --}}
                    @if($product->thumbnail)
                        <button onclick="document.getElementById('main-image').src='{{ asset('storage/' . $product->thumbnail) }}'" class="aspect-square overflow-hidden rounded-lg bg-gray-100 border-2 border-brand hover:border-brand transition">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                    @endif
                    @foreach($product->productImages as $image)
                        <button onclick="document.getElementById('main-image').src='{{ asset('storage/' . $image->image_path) }}'" class="aspect-square overflow-hidden rounded-lg bg-gray-100 border-2 border-gray-200 hover:border-brand transition">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div>
            @if($product->category)
                <a href="{{ route('shop.category', $product->category->slug) }}" class="text-sm font-medium text-brand hover:text-brand uppercase tracking-wider transition">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 class="text-2xl md:text-3xl font-bold text-ink mt-2">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="mt-4 flex items-baseline gap-3">
                @if($product->sale_price)
                    <span class="text-3xl font-bold text-brand">{{ config('store.currency') }} {{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-xl text-gray-400 line-through">{{ config('store.currency') }} {{ number_format($product->price, 2) }}</span>
                    @php
                        $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                    @endphp
                    <span class="bg-red-100 text-red-700 text-sm font-semibold px-2 py-0.5 rounded-full">-{{ $discount }}%</span>
                @else
                    <span class="text-3xl font-bold text-ink">{{ config('store.currency') }} {{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            {{-- Stock Status --}}
            <div class="mt-4 flex items-center gap-4">
                @if($product->stock > 0)
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                        <span class="text-sm text-green-700 font-medium">In Stock</span>
                        <span class="text-sm text-gray-400">({{ $product->stock }} available)</span>
                    </div>
                @else
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                        <span class="text-sm text-red-700 font-medium">Out of Stock</span>
                    </div>
                @endif

                @if($product->sku)
                    <span class="text-sm text-gray-400">SKU: {{ $product->sku }}</span>
                @endif
            </div>

            {{-- Description --}}
            @if($product->short_description)
                <p class="mt-6 text-gray-600 leading-relaxed">{{ $product->short_description }}</p>
            @endif

            {{-- Add to Cart Form --}}
            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mt-8">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex items-center gap-4 mb-4">
                        <label for="quantity" class="text-sm font-medium text-ink">Quantity:</label>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <button type="button" onclick="decrementQty()" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                </svg>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center border-x border-gray-300 py-2 text-sm focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="incrementQty()" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3 brand-gradient-bg hover:brightness-110 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        Add to Cart
                    </button>
                </form>
            @else
                <div class="mt-8 p-4 bg-gray-100 rounded-lg text-center">
                    <p class="text-gray-600 font-medium">This product is currently out of stock.</p>
                </div>
            @endif

            {{-- Full Description --}}
            @if($product->description)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-ink mb-3">Description</h3>
                    <div class="prose prose-stone prose-sm max-w-none text-gray-600 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count())
        <section class="mt-16 pt-12 border-t border-gray-200">
            <h2 class="text-2xl font-bold text-ink mb-6">Related Products</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach($relatedProducts as $related)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-lg border border-gray-200 overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
                        <a href="{{ route('shop.show', $related->slug) }}" class="block aspect-square overflow-hidden bg-gray-100">
                            @if($related->thumbnail)
                                <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-ink truncate">
                                <a href="{{ route('shop.show', $related->slug) }}" class="hover:text-brand transition">{{ $related->name }}</a>
                            </h3>
                            <div class="mt-2 flex items-center gap-2">
                                @if($related->sale_price)
                                    <span class="text-lg font-bold text-brand">{{ config('store.currency') }} {{ number_format($related->sale_price, 2) }}</span>
                                    <span class="text-sm text-gray-400 line-through">{{ config('store.currency') }} {{ number_format($related->price, 2) }}</span>
                                @else
                                    <span class="text-lg font-bold text-ink">{{ config('store.currency') }} {{ number_format($related->price, 2) }}</span>
                                @endif
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $related->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full py-2 brand-gradient-bg hover:brightness-110 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

@push('scripts')
<script>
    function decrementQty() {
        const input = document.getElementById('quantity');
        const val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    }
    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max) || 999;
        const val = parseInt(input.value) || 1;
        if (val < max) input.value = val + 1;
    }
</script>
@endpush

@endsection
