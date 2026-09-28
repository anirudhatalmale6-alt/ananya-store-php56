@extends('layouts.store')

@section('title', isset($category) ? $category->name . ' - KitchenCraft & Brass' : 'Shop - KitchenCraft & Brass')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-stone-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-700 transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('shop.index') }}" class="hover:text-amber-700 transition">Shop</a>
        @if(isset($category))
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-stone-800 font-medium">{{ $category->name }}</span>
        @endif
    </nav>

    {{-- Search Results Heading --}}
    @if(request('search'))
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-stone-800">
                Search results for "<span class="text-amber-700">{{ request('search') }}</span>"
            </h1>
            <p class="text-stone-500 mt-1">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
        </div>
    @elseif(isset($category))
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-stone-800">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-stone-500 mt-1">{{ $category->description }}</p>
            @endif
        </div>
    @else
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-stone-800">All Products</h1>
            <p class="text-stone-500 mt-1">Browse our complete collection</p>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar --}}
        <aside class="lg:w-64 shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-5 sticky top-4">

                {{-- Category Filter --}}
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-stone-800 uppercase tracking-wider mb-3">Categories</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('shop.index') }}" class="flex items-center justify-between px-3 py-2 text-sm rounded-lg transition {{ !isset($category) && !request('category') ? 'bg-amber-50 text-amber-800 font-medium' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-800' }}">
                                <span>All Products</span>
                                <span class="text-xs text-stone-400">{{ \App\Models\Product::active()->count() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('shop.category', $cat->slug) }}" class="flex items-center justify-between px-3 py-2 text-sm rounded-lg transition {{ (isset($category) && $category->id === $cat->id) || request('category') === $cat->slug ? 'bg-amber-50 text-amber-800 font-medium' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-800' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs text-stone-400">{{ $cat->products()->where('is_active', true)->count() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Price Range Filter --}}
                <div>
                    <h3 class="text-sm font-semibold text-stone-800 uppercase tracking-wider mb-3">Price Range</h3>
                    <form action="{{ isset($category) ? route('shop.category', $category->slug) : route('shop.index') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <div class="flex items-center gap-2 mb-3">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-sm">$</span>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full pl-7 pr-2 py-2 text-sm border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                            <span class="text-stone-400">-</span>
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-sm">$</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full pl-7 pr-2 py-2 text-sm border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-stone-800 hover:bg-stone-900 text-white text-sm font-medium rounded-lg transition">
                            Apply Filter
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-xl shadow-sm hover:shadow-lg border border-stone-200 overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
                            {{-- Product Image --}}
                            <a href="{{ route('shop.show', $product->slug) }}" class="block aspect-square overflow-hidden bg-stone-100">
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-100 to-stone-200">
                                        <svg class="w-16 h-16 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Sale Badge --}}
                                @if($product->sale_price)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-lg">
                                            SALE
                                        </span>
                                    </div>
                                @endif
                            </a>

                            {{-- Product Info --}}
                            <div class="p-4">
                                @if($product->category)
                                    <span class="text-xs font-medium text-amber-600 uppercase tracking-wider">{{ $product->category->name }}</span>
                                @endif
                                <h3 class="mt-1 text-sm font-semibold text-stone-800 truncate">
                                    <a href="{{ route('shop.show', $product->slug) }}" class="hover:text-amber-700 transition">{{ $product->name }}</a>
                                </h3>

                                {{-- Price --}}
                                <div class="mt-2 flex items-center gap-2">
                                    @if($product->sale_price)
                                        <span class="text-lg font-bold text-amber-700">{{ config('store.currency') }} {{ number_format($product->sale_price, 2) }}</span>
                                        <span class="text-sm text-stone-400 line-through">{{ config('store.currency') }} {{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-stone-800">{{ config('store.currency') }} {{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>

                                {{-- Buttons --}}
                                <div class="mt-3 flex gap-2">
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                            </svg>
                                            Add
                                        </button>
                                    </form>
                                    <a href="{{ route('shop.show', $product->slug) }}" class="py-2 px-3 border border-stone-300 text-stone-600 hover:border-amber-600 hover:text-amber-700 text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-stone-200">
                    <svg class="w-16 h-16 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-stone-800">No products found</h3>
                    <p class="text-stone-500 mt-1">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center mt-4 px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition">
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
