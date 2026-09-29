@extends('layouts.store')

@section('title', 'Ananya - Premium Kitchen Appliances, Brass Statues & Temple Items')

@section('content')

{{-- ============ HERO ============ --}}
<section class="relative overflow-hidden bg-gradient-to-br from-white via-white to-surface-alt">
    {{-- soft mandala glow --}}
    <div class="pointer-events-none absolute -right-24 top-1/2 -translate-y-1/2 w-[520px] h-[520px] rounded-full bg-brand/10 blur-2xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-8 items-center min-h-[460px] py-10">
            {{-- Text --}}
            <div class="relative z-10">
                <p class="flex items-center gap-2 text-brand-dark font-medium tracking-wide mb-3">
                    <span class="w-8 h-px bg-brand"></span> From Our Home to Yours
                </p>
                <h1 class="font-serif text-5xl md:text-6xl font-bold leading-[1.05] text-ink">
                    Elevate Every<br><span class="gold-gradient-text italic">Experience</span>
                </h1>
                <p class="mt-5 text-gray-500 text-lg max-w-md leading-relaxed">
                    Premium Kitchen Appliances, Divine Essentials &amp; Timeless Brass Creations.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-brand hover:bg-brand-light text-white font-semibold text-sm tracking-wide shadow-lg shadow-brand/20 transition transform hover:-translate-y-0.5">
                        EXPLORE COLLECTION
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full border border-brand/30 text-brand hover:border-brand hover:text-brand-dark font-semibold text-sm tracking-wide transition">
                        <span class="w-8 h-8 rounded-full bg-brand/20 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-brand-dark" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                        WATCH OUR STORY
                    </a>
                </div>
                <div class="mt-8 flex items-center gap-3 text-sm text-gray-400">
                    <span class="font-serif text-brand font-semibold">01</span>
                    <span class="w-10 h-0.5 bg-brand rounded"></span>
                    <span>02</span>
                    <span>03</span>
                </div>
            </div>
            {{-- Image --}}
            <div class="relative z-10 flex justify-center lg:justify-end">
                <img src="{{ asset('img/hero-products.png') }}" alt="Premium kitchen appliances and brass creations" class="w-full max-w-xl object-contain drop-shadow-xl">
            </div>
        </div>
    </div>
</section>

{{-- ============ CATEGORY CARDS ============ --}}
@php
    $catCards = [
        ['title' => 'Kitchen Appliances', 'img' => 'cat-mixer.png',     'tall' => true],
        ['title' => 'Brass Statues',      'img' => 'cat-statue.png',    'tall' => true],
        ['title' => 'Temple Items',        'img' => 'cat-lamp.png',      'tall' => true],
        ['title' => 'Hotel Kitchen',       'img' => 'cat-range.png',     'tall' => false],
        ['title' => 'Sowbhagya Brand',     'img' => 'cat-sowbhagya.png', 'tall' => false],
    ];
@endphp
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4 relative z-20 pb-14">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($catCards as $i => $c)
            <a href="{{ route('shop.index') }}"
               class="group bg-white rounded-2xl border border-brand/15 shadow-card hover:shadow-lg hover:border-brand/40 transition-all duration-300 p-4 flex {{ $c['tall'] ? 'flex-row items-center gap-3' : 'flex-col items-center text-center' }} {{ $i >= 3 ? 'lg:col-span-1' : '' }}">
                <div class="{{ $c['tall'] ? 'w-20 h-24' : 'w-full h-24' }} flex items-center justify-center shrink-0">
                    <img src="{{ asset('img/'.$c['img']) }}" alt="{{ $c['title'] }}" class="max-h-24 max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="{{ $c['tall'] ? '' : 'mt-3' }}">
                    <h3 class="font-serif text-lg text-ink leading-tight">{{ $c['title'] }}</h3>
                    <span class="mt-1 inline-flex items-center gap-1 text-xs font-semibold tracking-wide text-brand-dark uppercase">
                        Explore <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- ============ FEATURES STRIP ============ --}}
@php
    $features = [
        ['t' => 'Premium Quality Products', 'd' => 'Sourced from trusted manufacturers', 'icon' => 'badge'],
        ['t' => 'Wide Range Collection',    'd' => 'Everything you need under one roof', 'icon' => 'grid'],
        ['t' => 'Trusted by Thousands',     'd' => 'Serving customers across India', 'icon' => 'users'],
        ['t' => 'Secure Shopping Experience','d' => '100% secure payments & easy returns', 'icon' => 'shield'],
    ];
@endphp
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">
    <div class="rounded-2xl border border-brand/25 bg-white/60 shadow-card">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-brand/15">
            @foreach($features as $f)
                <div class="flex items-start gap-3 p-6">
                    <span class="shrink-0 w-11 h-11 rounded-full bg-brand/10 border border-brand/30 flex items-center justify-center text-brand-dark">
                        @if($f['icon']==='badge')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($f['icon']==='grid')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        @elseif($f['icon']==='users')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a3 3 0 10-3-3"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4.42-3.05 8.02-7 9-3.95-.98-7-4.58-7-9V7l7-4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                        @endif
                    </span>
                    <div>
                        <h4 class="font-semibold text-ink text-sm">{{ $f['t'] }}</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $f['d'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ EXCLUSIVE OFFERS ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="text-center mb-8">
        <h2 class="font-serif text-3xl text-ink">Exclusive Offers</h2>
        <span class="mt-2 inline-block w-24 h-0.5 bg-brand rounded"></span>
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Big festive card --}}
        <div class="relative overflow-hidden rounded-2xl border border-brand/25 bg-gradient-to-r from-surface-alt to-white shadow-card">
            <div class="flex items-center h-full">
                <div class="p-8 flex-1">
                    <h3 class="font-serif text-2xl md:text-3xl text-ink"><span class="text-brand-dark">Festive</span> Mega Sale</h3>
                    <p class="mt-2 text-gray-500">Up to</p>
                    <p class="font-serif text-5xl md:text-6xl font-bold text-brand leading-none">30<span class="text-brand-dark text-3xl align-top">% OFF</span></p>
                    <a href="{{ route('shop.index') }}" class="mt-5 inline-flex items-center gap-2 px-6 py-3 rounded-full bg-brand hover:bg-brand-light text-white text-sm font-semibold tracking-wide transition">
                        SHOP NOW <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <div class="w-40 md:w-52 shrink-0 self-stretch flex items-center justify-center pr-4">
                    <img src="{{ asset('img/offer-lamp.png') }}" alt="Festive brass lamp" class="max-h-56 object-contain">
                </div>
            </div>
        </div>
        {{-- Two small cards --}}
        <div class="grid grid-rows-2 gap-6">
            <div class="flex items-center rounded-2xl border border-brand/25 bg-white shadow-card overflow-hidden">
                <div class="p-6 flex-1">
                    <h4 class="font-serif text-lg text-ink">Sowbhagya Special Offer</h4>
                    <p class="font-serif text-2xl font-bold text-brand-dark mt-1">20% OFF</p>
                    <a href="{{ route('shop.index') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold tracking-wide text-brand uppercase hover:text-brand-dark transition">
                        Shop Now <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <img src="{{ asset('img/offer-mixer.png') }}" alt="Sowbhagya mixer" class="h-24 object-contain pr-6">
            </div>
            <div class="flex items-center rounded-2xl border border-brand/25 bg-white shadow-card overflow-hidden">
                <div class="p-6 flex-1">
                    <h4 class="font-serif text-lg text-ink">Hotel Kitchen Combo Offers</h4>
                    <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">Starting from</p>
                    <p class="font-serif text-2xl font-bold text-brand-dark">{{ config('store.currency') }} 24,999</p>
                    <a href="{{ route('shop.index') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold tracking-wide text-brand uppercase hover:text-brand-dark transition">
                        Shop Now <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <img src="{{ asset('img/offer-range.png') }}" alt="Hotel kitchen range" class="h-24 object-contain pr-6">
            </div>
        </div>
    </div>
</section>

{{-- ============ AUTHORIZED BRAND ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="text-center mb-6">
        <p class="text-xs tracking-[0.25em] uppercase text-gray-400">Authorized Agents of</p>
        <img src="{{ asset('img/cat-sowbhagya.png') }}" alt="Sowbhagya" class="h-16 mx-auto my-3 object-contain">
        <p class="text-gray-500 text-sm">Trusted Brand. Trusted by Millions.</p>
    </div>

    @php
        $brandTrust = [
            ['t' => '100% Quality Products', 'icon' => 'badge'],
            ['t' => 'Authorized Dealer',     'icon' => 'shield'],
            ['t' => 'Manufacturer Warranty', 'icon' => 'doc'],
            ['t' => 'After Sales Support',   'icon' => 'headset'],
        ];
        $service = [
            ['t' => 'Pan India Delivery', 'icon' => 'truck'],
            ['t' => 'Secure Payments',    'icon' => 'lock'],
            ['t' => 'Easy Returns',       'icon' => 'refresh'],
            ['t' => '24/7 Customer Support', 'icon' => 'headset'],
        ];
    @endphp

    <div class="rounded-2xl border border-brand/25 bg-white/60 shadow-card mb-5">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-y lg:divide-y-0 divide-brand/15">
            @foreach($brandTrust as $b)
                <div class="flex flex-col items-center text-center gap-2 p-6">
                    <span class="w-11 h-11 rounded-full bg-brand/10 border border-brand/30 flex items-center justify-center text-brand-dark">@include('partials.trust-icon', ['icon' => $b['icon']])</span>
                    <span class="text-sm font-medium text-ink">{{ $b['t'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="rounded-2xl border border-brand/25 bg-surface-alt/50 shadow-card">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-y lg:divide-y-0 divide-brand/15">
            @foreach($service as $s)
                <div class="flex flex-col items-center text-center gap-2 p-6">
                    <span class="w-11 h-11 rounded-full bg-brand/5 border border-brand/15 flex items-center justify-center text-brand">@include('partials.trust-icon', ['icon' => $s['icon']])</span>
                    <span class="text-sm font-medium text-ink">{{ $s['t'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
