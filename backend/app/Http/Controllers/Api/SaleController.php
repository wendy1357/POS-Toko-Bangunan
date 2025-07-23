<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Wajib untuk Database Transaction
use Illuminate\Http\JsonResponse;
class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request): JsonResponse
    {
        // 1. Validasi data utama yang masuk
        $validatedData = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'amount_paid' => 'required|numeric|min:0',
            'cart' => 'required|array',
            'cart.*.product_unit_id' => 'required|exists:product_units,id',
            'cart.*.quantity' => 'required|numeric|min:1',
        ]);

        // 2. Gunakan Database Transaction
        // Ini memastikan jika ada satu langkah gagal, semua proses akan dibatalkan (rollback).
        // Mencegah data korup (misal: sale tercatat tapi stok tidak berkurang).
        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $cartItems = [];

            // 3. Loop pertama: Validasi Stok & Hitung Total
            foreach ($validatedData['cart'] as $item) {
                $productUnit = ProductUnit::with('product')->find($item['product_unit_id']);
                $product = $productUnit->product;

                $quantityInBaseUnit = $item['quantity'] * $productUnit->conversion_rate;

                // Cek stok
                if ($product->stock_in_base_unit < $quantityInBaseUnit) {
                    // Batalkan transaksi jika stok tidak cukup
                    throw new \Exception('Stok untuk produk ' . $product->nama_produk . ' tidak mencukupi.');
                }

                $subtotal = $item['quantity'] * $productUnit->harga_jual;
                $totalAmount += $subtotal;
                
                // Simpan info untuk loop kedua
                $cartItems[] = [
                    'product_unit' => $productUnit,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
$transactionCode = 'INV/' . now()->format('Ymd') . '/' . strtoupper(uniqid());

    // 4. Buat record utama di tabel 'sales'
    $sale = Sale::create([
        'transaction_code' => $transactionCode, // <-- TAMBAHKAN INI
        'customer_id' => $validatedData['customer_id'] ?? null,
        'user_id' => auth()->id(), // Ganti ini dulu untuk sementara
        'total_amount' => $totalAmount,
                'amount_paid' => $validatedData['amount_paid'],
                'change_due' => $validatedData['amount_paid'] - $totalAmount,
                'payment_method' => 'Cash', // Bisa dikembangkan nanti
                'payment_status' => ($validatedData['amount_paid'] >= $totalAmount) ? 'Lunas' : 'Bayar Sebagian',
                'transaction_date' => now(),
            ]);

            // 5. Loop kedua: Buat 'sale_details' & Kurangi Stok
            foreach ($cartItems as $item) {
                $sale->details()->create([
                    'product_unit_id' => $item['product_unit']->id,
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $item['product_unit']->harga_jual,
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi stok produk
                $productToUpdate = $item['product_unit']->product;
                $quantityToDecrement = $item['quantity'] * $item['product_unit']->conversion_rate;
                $productToUpdate->decrement('stock_in_base_unit', $quantityToDecrement);
            }

            // Jika semua berhasil, simpan perubahan ke database
            DB::commit();

            return response()->json($sale->load('details'), 201);

        } catch (\Exception $e) {
            // Jika terjadi error, batalkan semua query
            DB::rollBack();
            // Kembalikan response error
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
