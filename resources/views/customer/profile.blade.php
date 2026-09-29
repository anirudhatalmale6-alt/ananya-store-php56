@extends('layouts.store')

@section('title', 'Edit Profile - KitchenCraft & Brass')

@section('content')

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand transition">Home</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('customer.dashboard') }}" class="hover:text-brand transition">My Account</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-ink font-medium">Edit Profile</span>
    </nav>

    <h1 class="text-2xl font-bold text-ink mb-8">Edit Profile</h1>

    <form action="{{ route('customer.profile.update') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            {{-- Personal Information --}}
            <h2 class="text-lg font-semibold text-ink mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Name --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-ink mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('name')) border-red-500 @endif">
                    @if($errors->has('name'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-ink mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('email')) border-red-500 @endif">
                    @if($errors->has('email'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-ink mb-1">Phone</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone ?: '') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('phone')) border-red-500 @endif">
                    @if($errors->has('phone'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('phone') }}</p>
                    @endif
                </div>
            </div>

            <hr class="border-gray-200 my-6">

            {{-- Address Information --}}
            <h2 class="text-lg font-semibold text-ink mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Address Details
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Address --}}
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-ink mb-1">Street Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', Auth::user()->address ?: '') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('address')) border-red-500 @endif">
                    @if($errors->has('address'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('address') }}</p>
                    @endif
                </div>

                {{-- City --}}
                <div>
                    <label for="city" class="block text-sm font-medium text-ink mb-1">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city', Auth::user()->city ?: '') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('city')) border-red-500 @endif">
                    @if($errors->has('city'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('city') }}</p>
                    @endif
                </div>

                {{-- State --}}
                <div>
                    <label for="state" class="block text-sm font-medium text-ink mb-1">State / Province</label>
                    <input type="text" name="state" id="state" value="{{ old('state', Auth::user()->state ?: '') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('state')) border-red-500 @endif">
                    @if($errors->has('state'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('state') }}</p>
                    @endif
                </div>

                {{-- ZIP --}}
                <div>
                    <label for="zip" class="block text-sm font-medium text-ink mb-1">ZIP / Postal Code</label>
                    <input type="text" name="zip" id="zip" value="{{ old('zip', Auth::user()->zip ?: '') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('zip')) border-red-500 @endif">
                    @if($errors->has('zip'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('zip') }}</p>
                    @endif
                </div>

                {{-- Country --}}
                <div>
                    <label for="country" class="block text-sm font-medium text-ink mb-1">Country</label>
                    <input type="text" name="country" id="country" value="{{ old('country', Auth::user()->country ?: '') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand focus:border-transparent text-sm transition @if($errors->has('country')) border-red-500 @endif">
                    @if($errors->has('country'))
                        <p class="text-red-600 text-xs mt-1">{{ $errors->first('country') }}</p>
                    @endif
                </div>
            </div>

            {{-- Save Button --}}
            <div class="mt-8 flex items-center justify-between">
                <a href="{{ route('customer.dashboard') }}" class="text-sm text-gray-500 hover:text-ink transition">Cancel</a>
                <button type="submit" class="px-8 py-2.5 brand-gradient-bg hover:brightness-110 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
