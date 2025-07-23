<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        // Mengambil semua data produk beserta relasi 'category' dan 'units'-nya.
        // `with()` digunakan agar data relasi ikut terambil (Eager Loading).
        $products = Product::with('category', 'units')->get();

        // Mengembalikan data sebagai response JSON.
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'sku' => 'nullable|string|unique:products',
            'stock_in_base_unit' => 'required|numeric',
            'base_unit' => 'required|string',
            'harga_beli_per_base_unit' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        // 2. Buat produk baru
        $product = Product::create($validatedData);

        // 3. Kembalikan response
        return response()->json($product, 201); // 201 = Created
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Karena Laravel sudah otomatis menemukan produknya,
        // kita tinggal memuat relasinya dan mengembalikannya.
        return response()->json($product->load('category', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, Product $product)
    {
        // 1. Validasi data
        $validatedData = $request->validate([
            'nama_produk' => 'sometimes|required|string|max:150',
            // Periksa keunikan SKU, tapi abaikan untuk produk ini sendiri
            'sku' => ['nullable', 'string', Rule::unique('products')->ignore($product->id)],
            'stock_in_base_unit' => 'sometimes|required|numeric',
            'base_unit' => 'sometimes|required|string',
            'harga_beli_per_base_unit' => 'sometimes|required|numeric',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        // 2. Update produk
        $product->update($validatedData);

        // 3. Kembalikan produk yang sudah diupdate
        return response()->json($product);
    }
    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Product $product)
    {
        // 1. Hapus produk dari database
        $product->delete();

        // 2. Kembalikan response kosong dengan status 204
        return response()->json(null, 204); // 204 = No Content
    }
}
