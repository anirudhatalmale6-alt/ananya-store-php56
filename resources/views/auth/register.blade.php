@extends('layouts.store')

@section('title', 'Create Account - Ananya')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-14">

    <div class="text-center mb-8">
        <img src="{{ asset('img/logo-ananya.png') }}" alt="{{ config('store.name') }}" class="h-12 w-auto mx-auto object-contain">
        <h1 class="font-serif text-2xl text-ink mt-5">Create your account</h1>
        <p class="text-sm text-gray-500 mt-1">Track orders and check out faster</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-card p-7">
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-ink mb-1.5">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand {{ $errors->has('name') ? 'border-brand' : '' }}">
                @include('partials.field-error', ['field' => 'name'])
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-ink mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand {{ $errors->has('email') ? 'border-brand' : '' }}">
                @include('partials.field-error', ['field' => 'email'])
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-ink mb-1.5">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand {{ $errors->has('password') ? 'border-brand' : '' }}">
                @include('partials.field-error', ['field' => 'password'])
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-ink mb-1.5">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-lg bg-brand hover:bg-brand-dark text-white text-sm font-semibold tracking-wide uppercase transition">
                Create account
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Already registered?
            <a href="{{ route('login') }}" class="text-brand font-medium hover:text-brand-dark hover:underline">Log in</a>
        </p>
    </div>
</div>
@endsection
