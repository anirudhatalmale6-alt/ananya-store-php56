@extends('layouts.store')

@section('title', 'Reset Password - Ananya')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-14">

    <div class="text-center mb-8">
        <img src="{{ asset('img/logo-ananya.png') }}" alt="{{ config('store.name') }}" class="h-12 w-auto mx-auto object-contain">
        <h1 class="font-serif text-2xl text-ink mt-5">Forgot your password?</h1>
        <p class="text-sm text-gray-500 mt-1">We'll email you a link to choose a new one.</p>
    </div>

    @if(session('status'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-2xl shadow-card p-7">
        <form method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-ink mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand {{ $errors->has('email') ? 'border-brand' : '' }}">
                @include('partials.field-error', ['field' => 'email'])
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-lg bg-brand hover:bg-brand-dark text-white text-sm font-semibold tracking-wide uppercase transition">
                Email password reset link
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ route('login') }}" class="text-brand font-medium hover:text-brand-dark hover:underline">Back to login</a>
        </p>
    </div>
</div>
@endsection
