@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Category</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 max-w-2xl">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm"
                       required>
                @if($errors->has('name'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                @endif
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm">{{ old('description', $category->description) }}</textarea>
                @if($errors->has('description'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('description') }}</p>
                @endif
            </div>

            {{-- Current Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Image</label>
                @if($category->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 rounded-lg object-cover">
                    </div>
                @else
                    <p class="text-sm text-gray-500 mb-3">No image uploaded.</p>
                @endif

                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Change Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand hover:file:bg-brand-100">
                @if($errors->has('image'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('image') }}</p>
                @endif
            </div>

            {{-- Is Active --}}
            <div class="flex items-center">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand"
                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex items-center px-6 py-2.5 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-surface-alt transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
