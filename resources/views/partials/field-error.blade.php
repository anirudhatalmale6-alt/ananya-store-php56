{{-- Usage: @include('partials.field-error', ['field' => 'email']) --}}
@if($errors->has($field))
    <p class="text-brand text-xs mt-1">{{ $errors->first($field) }}</p>
@endif
