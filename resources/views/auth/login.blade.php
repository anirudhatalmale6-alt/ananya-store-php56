@extends('layouts.store')

@section('title', 'Login - Ananya')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-14">

    <div class="text-center mb-8">
        <img src="{{ asset('img/logo-ananya.png') }}" alt="{{ config('store.name') }}" class="h-12 w-auto mx-auto object-contain">
        <h1 class="font-serif text-2xl text-ink mt-5">Welcome back</h1>
        <p class="text-sm text-gray-500 mt-1">Sign in to your account to continue</p>
    </div>

    @if(session('status'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-2xl shadow-card p-7">
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-ink mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand {{ $errors->has('email') ? 'border-brand' : '' }}">
                @include('partials.field-error', ['field' => 'email'])
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-ink mb-1.5">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand {{ $errors->has('password') ? 'border-brand' : '' }}">
                @include('partials.field-error', ['field' => 'password'])
            </div>

            <div class="flex items-center justify-between mb-6">
                <label for="remember" class="flex items-center gap-2 text-sm text-gray-600">
                    <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-brand focus:ring-brand">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-brand hover:text-brand-dark hover:underline">Forgot password?</a>
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-lg bg-brand hover:bg-brand-dark text-white text-sm font-semibold tracking-wide uppercase transition">
                Log in
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-brand font-medium hover:text-brand-dark hover:underline">Create one</a>
        </p>
    </div>
</div>
@endsection
