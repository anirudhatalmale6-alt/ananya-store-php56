<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * The mass-assignable product fields taken straight from the request.
     *
     * @var array
     */
    protected $productFields = array(
        'name',
        'category_id',
        'description',
        'short_description',
        'price',
        'sale_price',
        'stock',
        'sku',
        'weight',
    );

    /**
     * Display a paginated listing of products with search and filter.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search by name or SKU
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        $categoryId = $request->input('category_id');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter by active status
        if ($request->has('is_active') && $request->input('is_active') !== '') {
            $query->where('is_active', $this->boolInput($request, 'is_active'));
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->input('is_featured') !== '') {
            $query->where('is_featured', $this->boolInput($request, 'is_featured'));
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules($request));

        $data = $request->only($this->productFields);

        $data['slug'] = Str::slug($data['name']);

        // Ensure unique slug
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Product::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        $data['is_active']   = $this->boolInput($request, 'is_active', true);
        $data['is_featured'] = $this->boolInput($request, 'is_featured', false);

        $data = $this->normaliseNullables($data);

        $product = Product::create($data);

        // Handle multiple product images upload
        $images = $request->file('images');
        if (! empty($images)) {
            foreach ($images as $index => $image) {
                $path = $image->store('products/images', 'public');
                ProductImage::create(array(
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ));
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(array('category', 'productImages'));

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $product->load('productImages');
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, $this->rules($request, $product));

        $data = $request->only($this->productFields);

        $data['slug'] = Str::slug($data['name']);

        // Ensure unique slug (excluding the current product)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Product::where('slug', $data['slug'])->where('id', '!=', $product->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        $data['is_active']   = $this->boolInput($request, 'is_active', true);
        $data['is_featured'] = $this->boolInput($request, 'is_featured', false);

        $data = $this->normaliseNullables($data);

        $product->update($data);

        // Handle multiple product images upload
        $images = $request->file('images');
        if (! empty($images)) {
            $maxSortOrder = $this->maxSortOrder($product);
            foreach ($images as $index => $image) {
                $path = $image->store('products/images', 'public');
                ProductImage::create(array(
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $maxSortOrder + $index + 1,
                ));
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete thumbnail
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        // Delete all product images from storage
        foreach ($product->productImages as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Add images to an existing product.
     */
    public function addImages(Request $request, Product $product)
    {
        $this->validate($request, array(
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ));

        $maxSortOrder = $this->maxSortOrder($product);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products/images', 'public');
            ProductImage::create(array(
                'product_id' => $product->id,
                'image_path' => $path,
                'sort_order' => $maxSortOrder + $index + 1,
            ));
        }

        return redirect()
            ->back()
            ->with('success', 'Images added successfully.');
    }

    /**
     * Remove a specific image from a product.
     */
    public function removeImage(Product $product, ProductImage $image)
    {
        // Ensure the image belongs to this product
        if ($image->product_id !== $product->id) {
            return redirect()
                ->back()
                ->with('error', 'Image does not belong to this product.');
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()
            ->back()
            ->with('success', 'Image removed successfully.');
    }

    /**
     * Validation rules shared by store() and update().
     *
     * Note: the "lt:price" rule was introduced in Laravel 5.6, so the
     * sale-price-below-price check is expressed with "max" against the
     * submitted price instead.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product|null  $product
     * @return array
     */
    protected function rules(Request $request, Product $product = null)
    {
        $skuRule = 'nullable|string|max:100|unique:products,sku';
        if ($product) {
            $skuRule .= ',' . $product->id;
        }

        $salePriceRule = 'nullable|numeric|min:0';
        $price = $request->input('price');
        if (is_numeric($price)) {
            // Sale price must stay strictly below the regular price.
            $salePriceRule .= '|max:' . max(0, (float) $price - 0.01);
        }

        return array(
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => $salePriceRule,
            'stock'             => 'required|integer|min:0',
            'sku'               => $skuRule,
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'weight'            => 'nullable|numeric|min:0',
            'is_active'         => 'nullable|boolean',
            'is_featured'       => 'nullable|boolean',
        );
    }

    /**
     * Turn empty-string optional inputs into real NULLs.
     *
     * @param  array $data
     * @return array
     */
    protected function normaliseNullables(array $data)
    {
        foreach (array('sale_price', 'weight', 'sku', 'short_description', 'description') as $key) {
            if (array_key_exists($key, $data) && $data[$key] === '') {
                $data[$key] = null;
            }
        }

        return $data;
    }

    /**
     * Highest existing sort_order for a product's gallery (-1 when empty).
     *
     * @param  \App\Models\Product $product
     * @return int
     */
    protected function maxSortOrder(Product $product)
    {
        $max = $product->productImages()->max('sort_order');

        return $max === null ? -1 : (int) $max;
    }
}
