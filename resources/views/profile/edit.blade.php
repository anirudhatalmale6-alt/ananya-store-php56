@extends('layouts.store')

@section('title', 'Account Settings - Ananya')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <h1 class="font-serif text-2xl text-ink mb-1">Account settings</h1>
    <p class="text-sm text-gray-500 mb-8">Update your login details or close your account.</p>

    @if(session('status') === 'profile-updated')
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">Profile updated.</div>
    @endif
    @if(session('status') === 'password-updated')
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">Password updated.</div>
    @endif

    {{-- Profile information --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-card p-7 mb-6">
        <h2 class="font-semibold text-ink mb-1">Profile information</h2>
        <p class="text-sm text-gray-500 mb-5">Your name and email address.</p>

        <form method="POST" action="{{ route('profile.update') }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-ink mb-1.5">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
                @include('partials.field-error', ['field' => 'name'])
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-ink mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
                @include('partials.field-error', ['field' => 'email'])
            </div>

            <button type="submit" class="px-6 py-2.5 rounded-lg bg-brand hover:bg-brand-dark text-white text-sm font-semibold transition">Save</button>
        </form>
    </div>

    {{-- Password --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-card p-7 mb-6">
        <h2 class="font-semibold text-ink mb-1">Update password</h2>
        <p class="text-sm text-gray-500 mb-5">Use a long, random password to stay secure.</p>

        <form method="POST" action="{{ route('password.update') }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-ink mb-1.5">Current password</label>
                <input id="current_password" type="password" name="current_password"
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
                @if($errors->updatePassword->has('current_password'))
                    <p class="text-brand text-xs mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-ink mb-1.5">New password</label>
                <input id="new_password" type="password" name="password"
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
                @include('partials.field-error', ['field' => 'password'])
            </div>

            <div class="mb-5">
                <label for="password_confirmation" class="block text-sm font-medium text-ink mb-1.5">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
            </div>

            <button type="submit" class="px-6 py-2.5 rounded-lg bg-brand hover:bg-brand-dark text-white text-sm font-semibold transition">Update password</button>
        </form>
    </div>

    {{-- Delete account --}}
    <div class="bg-white border border-brand/30 rounded-2xl shadow-card p-7">
        <h2 class="font-semibold text-brand mb-1">Delete account</h2>
        <p class="text-sm text-gray-500 mb-5">This permanently removes your account and order history. This cannot be undone.</p>

        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Permanently delete your account? This cannot be undone.');">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <div class="mb-5 max-w-sm">
                <label for="delete_password" class="block text-sm font-medium text-ink mb-1.5">Confirm your password</label>
                <input id="delete_password" type="password" name="password"
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
                @if($errors->userDeletion->has('password'))
                    <p class="text-brand text-xs mt-1">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <button type="submit" class="px-6 py-2.5 rounded-lg bg-brand hover:bg-brand-dark text-white text-sm font-semibold transition">Delete account</button>
        </form>
    </div>
</div>
@endsection
