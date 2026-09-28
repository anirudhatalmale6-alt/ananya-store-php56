<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Ananya - Where Tradition Meets Excellence')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-ink">

@php
    // Homepage nav mirrors the client's storefront design.
    $mainNav = [
        ['label' => 'Kitchen Appliances', 'url' => route('shop.index')],
        ['label' => 'Brass Statues',      'url' => route('shop.index')],
        ['label' => 'Temple Items',        'url' => route('shop.index')],
        ['label' => 'Hotel Kitchen',       'url' => route('shop.index')],
        ['label' => 'Sowbhagya Brand',     'url' => route('shop.index')],
        ['label' => 'Offers',              'url' => route('shop.index')],
    ];
    $navCartCount = 0;
    if (isset($cartItemCount)) { $navCartCount = $cartItemCount; }
@endphp

{{-- ============ TOP ANNOUNCEMENT BAR ============ --}}
<div class="bg-brand text-white text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-9">
        <div class="flex items-center gap-2">
            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v6.114A4.369 4.369 0 005 11c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v3.894A4.37 4.37 0 0015 10c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg>
            <span class="tracking-wide">Welcome to Ananya &ndash; Where Tradition Meets Excellence</span>
        </div>
        <div class="hidden sm:flex items-center gap-5">
            <a href="{{ route('shop.index') }}" class="flex items-center gap-1.5 hover:text-white/75 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM20 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 001 1h2m-3-1V8a1 1 0 011-1h3.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1"/></svg>
                Track Order
            </a>
            <a href="{{ route('shop.index') }}" class="flex items-center gap-1.5 hover:text-white/75 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Wishlist
            </a>
            @auth
                <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-1.5 hover:text-white/75 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ Str::limit(Auth::user()->name, 12) }}
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-1.5 hover:text-white/75 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Login / Register
                </a>
            @endauth
        </div>
    </div>
</div>

{{-- ============ MAIN HEADER ============ --}}
<header class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-6 h-24">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0">
                <img src="{{ asset('img/logo-ananya.png') }}" alt="Ananya" class="h-14 w-auto max-w-[240px] object-contain">
            </a>

            {{-- Search --}}
            <form action="{{ route('shop.index') }}" method="GET" class="hidden md:flex flex-1 max-w-2xl mx-auto">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search for products, categories..."
                        class="w-full pl-5 pr-16 py-3 rounded-full bg-white border border-gray-300 text-sm text-ink placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-brand/50 focus:border-brand shadow-sm">
                    <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-11 h-9 rounded-full bg-brand hover:bg-brand-dark text-white flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>

            {{-- Actions --}}
            <div class="flex items-center gap-6 shrink-0">
                <a href="{{ route('shop.index') }}" class="hidden lg:flex items-center gap-2 text-brand hover:text-brand-dark transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    <span class="text-sm font-medium">Compare</span>
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center gap-2 text-brand hover:text-brand-dark transition">
                    <span class="relative">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <span class="absolute -top-2 -right-2 bg-brand text-white text-[10px] font-bold rounded-full w-4.5 h-4.5 min-w-[18px] h-[18px] flex items-center justify-center px-1">{{ $navCartCount > 99 ? '99+' : $navCartCount }}</span>
                    </span>
                    <span class="hidden sm:block text-sm font-medium leading-tight">My Cart</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ============ CATEGORY NAV ============ --}}
    <nav class="border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="hidden md:flex items-center justify-between w-full">
                    @foreach($mainNav as $item)
                        <a href="{{ $item['url'] }}" class="py-3.5 text-[13px] font-semibold tracking-wide uppercase text-brand hover:text-brand-dark transition-colors relative group">
                            {{ $item['label'] }}
                            <span class="absolute left-0 -bottom-px h-0.5 w-0 bg-brand group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @endforeach
                </div>
                {{-- Mobile nav toggle --}}
                <button class="md:hidden flex items-center gap-2 py-3 text-brand font-semibold text-sm" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Menu
                </button>
            </div>
            <div id="mobile-menu" class="md:hidden hidden pb-3">
                @foreach($mainNav as $item)
                    <a href="{{ $item['url'] }}" class="block px-2 py-2 text-sm font-medium text-brand hover:text-brand-dark uppercase tracking-wide">{{ $item['label'] }}</a>
                @endforeach
            </div>
        </div>
    </nav>
</header>

{{-- Flash messages --}}
@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
    </div>
@endif
@if($errors->any())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
@endif

<main>
    @yield('content')
</main>

{{-- ============ VALUES BAND ============ --}}
<section class="bg-ink text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-center">
            <div class="text-center">
                <div class="mx-auto mb-3 w-11 h-11 rounded-full border border-brand/50 flex items-center justify-center text-brand-soft">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h4 class="font-serif text-brand-soft text-lg">Premium Quality</h4>
                <p class="text-xs text-white/60 mt-1">Finest products, expertly curated</p>
            </div>
            <div class="text-center">
                <div class="mx-auto mb-3 w-11 h-11 rounded-full border border-brand/50 flex items-center justify-center text-brand-soft">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h4 class="font-serif text-brand-soft text-lg">Divine Tradition</h4>
                <p class="text-xs text-white/60 mt-1">Bringing tradition into your life</p>
            </div>
            <div class="flex justify-center">
                <span class="relative flex items-center justify-center w-20 h-20 rounded-full border-2 border-brand/60">
                    <span class="absolute inset-2 rounded-full border border-brand/30"></span>
                    <span class="font-serif text-4xl font-bold text-brand-soft">A</span>
                </span>
            </div>
            <div class="text-center">
                <div class="mx-auto mb-3 w-11 h-11 rounded-full border border-brand/50 flex items-center justify-center text-brand-soft">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h4 class="font-serif text-brand-soft text-lg">Modern Excellence</h4>
                <p class="text-xs text-white/60 mt-1">Blending technology with tradition</p>
            </div>
            <div class="text-center lg:text-left">
                <h4 class="font-semibold text-brand-soft text-sm tracking-wide uppercase">Stay Updated</h4>
                <p class="text-xs text-white/60 mt-1 mb-3">Subscribe for special offers and latest updates</p>
                <form action="{{ route('home') }}" method="GET" class="flex">
                    <input type="email" name="newsletter" placeholder="Enter your email" class="flex-1 min-w-0 px-3 py-2 rounded-l-md bg-white text-ink text-sm border-0 focus:ring-2 focus:ring-brand placeholder-stone-400">
                    <button type="submit" class="px-3 rounded-r-md bg-brand hover:bg-brand-dark text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ============ FOOTER ============ --}}
<footer class="bg-ink text-white/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8 text-sm">
            <div>
                <h5 class="text-brand-soft font-semibold uppercase tracking-wider text-xs mb-4">Shop by Category</h5>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Kitchen Appliances</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Brass Statues</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Temple Items</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Hotel Kitchen Appliances</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Sowbhagya Brand</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-brand-soft font-semibold uppercase tracking-wider text-xs mb-4">Customer Service</h5>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Track Order</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Returns &amp; Refunds</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Shipping Policy</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">FAQ's</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-brand-soft font-semibold uppercase tracking-wider text-xs mb-4">Company</h5>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">About Us</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Our Story</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Careers</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Blog</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-brand-soft font-semibold uppercase tracking-wider text-xs mb-4">Useful Links</h5>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Gift Cards &amp; Discounts</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Bulk &amp; B2B</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-brand-soft transition">Corporate Enquiries</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-brand-soft font-semibold uppercase tracking-wider text-xs mb-4">Follow Us</h5>
                <div class="flex gap-3 mb-6">
                    @foreach(['facebook','instagram','youtube','whatsapp'] as $soc)
                        <a href="#" class="w-9 h-9 rounded-full border border-white/25 flex items-center justify-center text-brand-soft hover:bg-brand hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                @if($soc==='facebook')<path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987H7.898v-2.89h2.54V9.797c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                @elseif($soc==='instagram')<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                @elseif($soc==='youtube')<path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                @else<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.463 3.488"/>@endif
                            </svg>
                        </a>
                    @endforeach
                </div>
                <h5 class="text-brand-soft font-semibold uppercase tracking-wider text-xs mb-3">We Accept</h5>
                <div class="flex flex-wrap gap-2">
                    @foreach(['VISA','MASTERCARD','RuPay','UPI'] as $pay)
                        <span class="px-2.5 py-1 rounded bg-white text-ink text-[10px] font-bold tracking-wide">{{ $pay }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-brand/15">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 text-center text-xs text-white/50">
            &copy; {{ date('Y') }} Ananya. All rights reserved. &nbsp;|&nbsp; Handcrafted with tradition.
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
