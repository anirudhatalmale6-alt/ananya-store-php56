<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('store.name', 'Ananya') . ' - ' . config('store.tagline'))</title>

    {{-- Fonts: Cinzel (display) + Plus Jakarta Sans (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="font-sans bg-white text-ink antialiased custom-scrollbar">

@php
    $navItems = array(
        array('label' => 'Kitchen Appliances', 'slug' => 'kitchen-appliances', 'badge' => null),
        array('label' => 'Brass Statues',      'slug' => 'brass-statues',      'badge' => 'Handcrafted'),
        array('label' => 'Temple Items',       'slug' => 'temple-items',       'badge' => null),
        array('label' => 'Hotel Kitchen',      'slug' => 'hotel-kitchen',      'badge' => null),
        array('label' => 'Sowbhagya Brand',    'slug' => 'sowbhagya-brand',    'badge' => null, 'highlight' => true),
    );
    $navCartCount = isset($cartItemCount) ? $cartItemCount : 0;
    $navCats = isset($navCategories) ? $navCategories : collect();
    $activeCat = request('category');
@endphp

{{-- ============================ TOP ANNOUNCEMENT BAR ============================ --}}
<div class="brand-gradient-bg text-white text-xs py-2 px-4 shadow-sm border-b border-gold/30">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-gold animate-pulse"></span>
            <p class="font-medium tracking-wide">Welcome to {{ config('store.name') }} &ndash; {{ config('store.tagline') }}</p>
        </div>
        <div class="hidden md:flex items-center space-x-6 text-xs font-medium">
            <a href="{{ route('shop.index') }}" class="hover:text-gold-light transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM20 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 001 1h2m-3-1V8a1 1 0 011-1h3.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1"/></svg>
                Track Order
            </a>
            @if(Auth::check())
                <a href="{{ route('customer.dashboard') }}" class="hover:text-gold-light transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ Str::limit(Auth::user()->name, 14) }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    {{ csrf_field() }}
                    <button type="submit" class="hover:text-gold-light transition-colors">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-gold-light transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Account / Register
                </a>
            @endif
        </div>
    </div>
</div>

{{-- ============================ STICKY HEADER ============================ --}}
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-md border-b border-gold/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">

            {{-- Brand logo (client-supplied artwork) --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0 group">
                <img src="{{ asset('img/logo-ananya.png') }}" alt="{{ config('store.name') }}"
                     class="h-12 w-auto max-w-[210px] object-contain group-hover:scale-[1.03] transition-transform duration-300">
            </a>

            {{-- Search with category scope --}}
            <form action="{{ route('shop.index') }}" method="GET" class="hidden lg:flex flex-1 max-w-xl mx-8 relative">
                <div class="relative w-full flex items-center border-2 border-gray-200 rounded-full bg-gray-50/80 focus-within:border-brand focus-within:bg-white transition-all shadow-inner overflow-hidden">
                    <select name="category" class="bg-transparent text-xs font-semibold text-ink-muted pl-4 pr-2 py-2.5 border-r border-gray-200 focus:outline-none focus:ring-0 cursor-pointer max-w-[9.5rem] truncate">
                        <option value="">All Categories</option>
                        @foreach($navCats as $c)
                            <option value="{{ $c->slug }}" {{ $activeCat === $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search appliances, brass idols, temple items..."
                           class="w-full px-4 py-2 text-sm bg-transparent border-0 focus:outline-none focus:ring-0 text-ink placeholder-gray-400">
                    <button type="submit" class="brand-gradient-bg hover:opacity-95 text-white p-2.5 mr-1 rounded-full transition-all flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-gold-light" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            {{-- Utilities + cart --}}
            <div class="flex items-center gap-4 sm:gap-6">
                <a href="{{ route('shop.index') }}" class="hidden sm:flex items-center gap-1.5 text-xs font-semibold text-ink-muted hover:text-brand transition-colors group">
                    <span class="p-2 rounded-full group-hover:bg-brand-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-brand" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </span>
                    <span class="hidden md:inline">Compare</span>
                </a>

                <a href="{{ route('cart.index') }}"
                   class="flex items-center gap-2 brand-gradient-bg text-white px-4 py-2.5 rounded-full shadow-md hover:shadow-lg hover:brightness-110 transition-all border border-gold/40 group">
                    <svg class="w-5 h-5 text-gold-light group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span class="text-xs font-bold tracking-wide">MY CART</span>
                    <span class="bg-gold text-brand-darker text-[11px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow">{{ $navCartCount > 99 ? '99+' : $navCartCount }}</span>
                </a>

                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                        class="lg:hidden text-ink-muted hover:text-brand p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile search --}}
        <form action="{{ route('shop.index') }}" method="GET" class="lg:hidden pb-4">
            <div class="relative w-full flex items-center border border-gray-300 rounded-lg bg-white overflow-hidden shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                       class="w-full px-4 py-2 text-sm border-0 focus:outline-none focus:ring-0 text-ink">
                <button type="submit" class="brand-gradient-bg text-white px-4 py-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>
        </form>

        {{-- Category nav: labels are black; only the featured brand is red --}}
        <nav class="hidden lg:flex items-center justify-between border-t border-gray-100 py-3 text-sm font-semibold tracking-wide text-ink">
            <div class="flex space-x-8">
                @foreach($navItems as $item)
                    <a href="{{ route('shop.index') }}?category={{ $item['slug'] }}"
                       class="relative py-1 group flex items-center gap-1.5 transition-colors hover:text-brand">
                        <span class="{{ isset($item['highlight']) ? 'text-brand font-bold' : '' }}">{{ $item['label'] }}</span>
                        @if($item['badge'])
                            <span class="bg-gold/20 text-brand-dark text-[10px] uppercase font-extrabold px-1.5 py-0.5 rounded border border-gold/40">{{ $item['badge'] }}</span>
                        @endif
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand group-hover:w-full transition-all duration-300"></span>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('shop.index') }}"
               class="flex items-center gap-1.5 text-brand font-extrabold text-xs tracking-wider uppercase bg-brand-50 px-3 py-1.5 rounded-full border border-brand-100 hover:brand-gradient-bg hover:text-white hover:border-transparent transition-all">
                <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M10 1l2.09 5.26L18 7.27l-4 3.9.94 5.83L10 14.27 5.06 17l.94-5.83-4-3.9 5.91-1.01L10 1z"/></svg>
                Exclusive Offers
            </a>
        </nav>

        {{-- Mobile nav --}}
        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-100 py-2">
            @foreach($navItems as $item)
                <a href="{{ route('shop.index') }}?category={{ $item['slug'] }}"
                   class="block px-2 py-2.5 text-sm font-semibold {{ isset($item['highlight']) ? 'text-brand' : 'text-ink' }} hover:text-brand">{{ $item['label'] }}</a>
            @endforeach
            @if(Auth::check())
                <a href="{{ route('customer.dashboard') }}" class="block px-2 py-2.5 text-sm font-semibold text-ink hover:text-brand">My Account</a>
            @else
                <a href="{{ route('login') }}" class="block px-2 py-2.5 text-sm font-semibold text-ink hover:text-brand">Login / Register</a>
            @endif
        </div>
    </div>
</header>

{{-- ============================ FLASH MESSAGES ============================ --}}
@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
            <svg class="w-5 h-5 shrink-0 mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="flex items-start gap-3 bg-brand-50 border border-brand-100 text-brand-darker px-4 py-3 rounded-xl text-sm">
            <svg class="w-5 h-5 shrink-0 mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif
@if($errors->any())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-brand-50 border border-brand-100 text-brand-darker px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
@endif

<main>
    @yield('content')
</main>

{{-- ============================ FOOTER ============================ --}}
<footer class="bg-gray-950 text-gray-300 pt-16 pb-8 border-t-4 border-gold mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Newsletter --}}
        <div class="brand-gradient-bg rounded-2xl p-8 mb-12 shadow-2xl border border-gold/30 flex flex-col lg:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white">Join the {{ config('store.name') }} Circle</h3>
                <p class="text-xs text-white/80 mt-1">Subscribe for exclusive previews, artisan stories and special offers.</p>
            </div>
            <form action="{{ route('home') }}" method="GET" class="w-full lg:w-auto flex items-center gap-2">
                <input type="email" name="newsletter" placeholder="Enter your email address"
                       class="px-4 py-3 rounded-xl bg-black/40 border border-gold/40 text-sm text-white placeholder-gray-300 focus:outline-none focus:ring-0 focus:border-gold w-full sm:w-80">
                <button type="submit" class="gold-gradient-bg text-brand-darker font-black px-6 py-3 rounded-xl hover:brightness-110 transition-all shrink-0">
                    Subscribe
                </button>
            </form>
        </div>

        {{-- Columns --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-gray-800">

            <div class="lg:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="inline-flex items-center">
                    <img src="{{ asset('img/logo-ananya.png') }}" alt="{{ config('store.name') }}"
                         class="h-11 w-auto max-w-[190px] object-contain bg-white/95 rounded-lg px-2.5 py-1.5">
                </a>
                <p class="text-xs text-gray-400 leading-relaxed max-w-sm">
                    {{ config('store.name') }} blends timeless tradition with modern culinary innovation &mdash;
                    sourcing the finest brass sculptures, temple essentials and top-tier kitchen machinery.
                </p>
                <div class="flex items-center space-x-3 pt-2">
                    @foreach(array('facebook','instagram','youtube') as $soc)
                        <a href="#" aria-label="{{ $soc }}" class="w-8 h-8 rounded-full bg-gray-900 border border-gray-800 flex items-center justify-center hover:text-gold transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                @if($soc === 'facebook')<path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987H7.898v-2.89h2.54V9.797c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                @elseif($soc === 'instagram')<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                @else<path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>@endif
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="font-serif font-bold text-gold text-sm mb-4 tracking-wider uppercase">Shop Categories</h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    @forelse($navCats->take(5) as $c)
                        <li><a href="{{ route('shop.index') }}?category={{ $c->slug }}" class="hover:text-gold transition-colors">{{ $c->name }}</a></li>
                    @empty
                        <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">All Products</a></li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h4 class="font-serif font-bold text-gold text-sm mb-4 tracking-wider uppercase">Customer Service</h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li><a href="{{ Auth::check() ? route('customer.orders') : route('login') }}" class="hover:text-gold transition-colors">Track Your Order</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Returns &amp; Refunds</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Shipping Information</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Frequently Asked Questions</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Contact Support</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-serif font-bold text-gold text-sm mb-4 tracking-wider uppercase">Our Company</h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">About {{ config('store.name') }}</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Our Artisans &amp; Heritage</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Bulk &amp; Corporate Orders</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Terms of Service</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('store.name') }} Store. All rights reserved.</p>
            <div class="flex items-center space-x-2">
                @foreach(array('VISA','MASTERCARD','UPI','NETBANKING') as $pay)
                    <span class="px-2 py-1 bg-gray-900 rounded border border-gray-800 text-[10px] text-gray-300 font-bold">{{ $pay }}</span>
                @endforeach
            </div>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
