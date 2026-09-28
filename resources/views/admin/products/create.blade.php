@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Create Product</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 max-w-4xl">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            {{ csrf_field() }}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm"
                           required>
                    @if($errors->has('name'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                        Slug
                        <span class="text-gray-400 font-normal">(auto-generated if left empty)</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm"
                           placeholder="auto-generated-from-name">
                    @if($errors->has('slug'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('slug') }}</p>
                    @endif
                </div>

                {{-- Category --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" id="category_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm"
                            required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('category_id'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('category_id') }}</p>
                    @endif
                </div>

                {{-- SKU --}}
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm">
                    @if($errors->has('sku'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('sku') }}</p>
                    @endif
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm"
                           required>
                    @if($errors->has('price'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('price') }}</p>
                    @endif
                </div>

                {{-- Sale Price --}}
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">
                        Sale Price ($)
                        <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm">
                    @if($errors->has('sale_price'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('sale_price') }}</p>
                    @endif
                </div>

                {{-- Stock --}}
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm"
                           required>
                    @if($errors->has('stock'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('stock') }}</p>
                    @endif
                </div>

                {{-- Weight --}}
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">
                        Weight (kg)
                        <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <input type="number" name="weight" id="weight" value="{{ old('weight') }}" step="0.01" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm">
                    @if($errors->has('weight'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('weight') }}</p>
                    @endif
                </div>
            </div>

            {{-- Short Description --}}
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">
                    Short Description
                    <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <textarea name="short_description" id="short_description" rows="2"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm">{{ old('short_description') }}</textarea>
                @if($errors->has('short_description'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('short_description') }}</p>
                @endif
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="5"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand focus:ring-brand text-sm">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('description') }}</p>
                @endif
            </div>

            {{-- Thumbnail --}}
            <div>
                <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Image</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand hover:file:bg-brand-100">
                @if($errors->has('thumbnail'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('thumbnail') }}</p>
                @endif
            </div>

            {{-- Additional Images --}}
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">
                    Additional Images
                    <span class="text-gray-400 font-normal">(select multiple)</span>
                </label>
                <input type="file" name="images[]" id="images" accept="image/*" multiple
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand hover:file:bg-brand-100">
                @if($errors->has('images'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('images') }}</p>
                @endif
                @if($errors->has('images.*'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('images.*') }}</p>
                @endif
            </div>

            {{-- Checkboxes --}}
            <div class="flex items-center space-x-8">
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                </div>
                <div class="flex items-center">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                           class="h-4 w-4 rounded border-gray-300 text-brand focus:ring-brand"
                           {{ old('is_featured') ? 'checked' : '' }}>
                    <label for="is_featured" class="ml-2 text-sm text-gray-700">Featured</label>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-dark transition-colors">
                    Save Product
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex items-center px-6 py-2.5 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-surface-alt transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
