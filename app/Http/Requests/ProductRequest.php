<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin' && $this->user()->active;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $product = $this->route('product');
        $id = $product instanceof Product ? $product->id : null;

        return ['name' => 'required|string|max:150', 'slug' => ['required', 'string', 'max:160', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('products', 'slug')->ignore($id)], 'sku' => ['required', 'string', 'max:80', Rule::unique('products', 'sku')->ignore($id)], 'division' => 'required|in:b-melanox,bettyworld,bvalence,divine,novia,skin-safari', 'description' => 'required|string|max:10000', 'ingredients' => 'nullable|string|max:5000', 'usage' => 'nullable|string|max:5000', 'evidence_note' => 'nullable|string|max:5000', 'price' => 'required|integer|min:1|max:100000000', 'stock' => 'required|integer|min:0|max:1000000', 'published' => 'required|boolean', 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', 'image_path' => 'nullable|string|max:255|regex:#^img/products/[a-zA-Z0-9._-]+$#'];
    }
}
