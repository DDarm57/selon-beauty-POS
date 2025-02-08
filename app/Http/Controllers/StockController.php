<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $title = 'Stok';
      $data = Stock::with('product')->get()->sortByDesc('id');
      return view('pages.stock.index', compact('title', 'data'));
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
   public function store(Request $request)
   {
      $find = Product::where('id', $request->product_id)->first();

      if (!$find) {
         return redirect()->route('products.edit', ['id' => $request->product_id])->with('error', 'Produk tidak ditemukan!');
      }

      $messages = [
         'stock.required' => 'Nama wajib diisi!',
         'stock.numeric' => 'Harga harus berupa angka!',
         'stock.min' => 'Stok minimal 1!',
         'product_id.required' => 'Kategori wajib diisi!',
      ];

      $validated = $request->validate([
         'stock' => 'required|numeric|min:1',
         'product_id' => 'required',
      ], $messages);

      $stok = Stock::create([
         'stock' => $validated['stock'],
         'product_id' => $validated['product_id'],
      ]);

      $find->stock = $find->stock + $validated['stock'];
      $find->save();

      if ($stok) {
         return redirect()->route('products.edit', ['id' => $validated['product_id']])->with('success', 'Stok berhasil ditambahkan!');
      } else {
         return redirect()->route('products.edit', ['id' => $validated['product_id']])->with('error', 'Stok gagal ditambahkan!');
      }
   }

   /**
    * Display the specified resource.
    */
   public function show(string $id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(string $id)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
      $stock = Stock::findOrFail($id);
      $product = Product::findOrFail($stock->product_id);

      if (!$stock) {
         return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
      }

      $messages = [
         'stock_update.required' => 'Nama wajib diisi!',
         'stock_update.numeric' => 'Harga harus berupa angka!',
         'stock_update.min' => 'Stok minimal 1!',
      ];

      $validated = $request->validate([
         'stock_update' => 'required|numeric|min:1',
      ], $messages);


      // Hitung selisih stok yang diedit
      $oldStock = $stock->stock;
      $newStock = $validated['stock_update'];
      $stockDifference = $newStock - $oldStock;

      // Update stok di tabel stocks
      $stock->update([
         'stock' => $newStock
      ]);

      // Update stok total di tabel products
      $stockUpdated = $product->update([
         'stock' => $product->stock + $stockDifference
      ]);

      if ($stockUpdated) {
         return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
      } else {
         return redirect()->back()->with('error', 'Stok gagal diperbarui!');
      }
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      // 1. Cari data stok berdasarkan ID
      $stock = Stock::findOrFail($id);

      // 2. Ambil produk terkait berdasarkan `product_id` yang ada di tabel `stocks`
      $product = Product::findOrFail($stock->product_id);

      if (!$product && !$stock) {
         return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
      } else if (!$product) {
         return redirect()->back()->with('error', 'Produk tidak ditemukan.');
      } else if (!$stock) {
         return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
      } else if ($product && $stock) {

         $product->stock = max(0, $product->stock - $stock->stock);

         $product->save();
         // 4. Hapus data stok
         $delete = $stock->delete();
      }

      if (!$delete) {
         return redirect()->back()->with('error', 'Data stok gagal dihapus.');
      } else {
         return redirect()->back()->with('success', 'Data stok berhasil dihapus dan stok produk diperbarui.');
      }
   }
}
