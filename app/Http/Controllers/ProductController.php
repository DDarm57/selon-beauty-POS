<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $title = 'Data Produk';
      $data = Product::with('categories')->get();

      return view('pages.product.index')->with([
         'title' => $title,
         'data' => $data
      ]);
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      $title = 'Tambah Produk';
      $category = Category::all();
      return view('pages.product.create-product')->with([
         'title' => $title,
         'category' => $category
      ]);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'name.max' => 'Nama tidak boleh lebih dari 60 karakter!',
         'code.required' => 'Kode produk wajib diisi!',
         'code.unique' => 'Kode produk sudah terdaftar!',
         'price.required' => 'Harga wajib diisi!',
         'price.numeric' => 'Harga harus berupa angka!',
         'agent_price.required' => 'Harga agen wajib diisi!',
         'agent_price.numeric' => 'Harga agen harus berupa angka!',
         'discount.numeric' => 'Diskon harus berupa angka!',
         'categories.required' => 'Kategori wajib diisi!',
         'categories.*.exists' => 'Kategori tidak ditemukan!',
         'stock.required' => 'Stok wajib diisi!',
         'stock.numeric' => 'Stok harus berupa angka!',
         'image.image' => 'File harus berupa gambar!',
         'image.mimes' => 'File harus berupa jpeg, png, atau jpg!',
         'image.max' => 'Ukuran file tidak boleh lebih dari 5MB!',
      ];

      $validated = $request->validate([
         'name' => 'required|max:60',
         'code' => ['required', Rule::unique('products')->whereNull('deleted_at')],
         'price' => 'required|numeric',
         'agent_price' => 'required|numeric',
         'discount' => 'nullable|numeric',
         'categories' => 'required|array',
         'categories.*' => 'exists:categories,id',
         'stock' => 'required|numeric',
         'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
      ], $messages);

      if ($request->hasFile('image')) {
         $image = $request->file('image');
         $name = time() . '.' . $image->getClientOriginalExtension();
         $path = public_path('img/products');
         $image->move($path, $name);
         $validated['image'] = $name;
      } else {
         $validated['image'] = '';
      }

      $validated['price'] = str_replace('.', '', $validated['price']);
      $validated['agent_price'] = str_replace('.', '', $validated['agent_price']);
      $validated['discount'] = str_replace('.', '', $validated['discount']);

      $product = Product::create($validated);

      Stock::create([
         'product_id' => $product->id,
         'stock' => $validated['stock']
      ]);

      $product->categories()->attach($request->categories);

      if ($product) {
         return redirect()->route('products.create')->with('success', 'Produk berhasil ditambahkan!');
      } else {
         return redirect()->route('products.create')->with('error', 'Produk gagal ditambahkan!');
      }
   }

   public function search(Request $request)
   {
      $query = $request->get('search');

      // Pencarian berdasarkan nama, kode, dan kategori
      $products = Product::with('category') // Pastikan relasi category sudah benar
         ->where('name', 'like', "%{$query}%")
         ->orWhere('code', 'like', "%{$query}%")
         ->get();

      return response()->json($products);
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
      $title = 'Detail Produk';
      $data = Product::with('categories', 'stocks')->find($id);
      $category = Category::all();

      if (!$data) {
         return redirect()->route('products')->with('error', 'Produk tidak ditemukan');
      } else {
         return view('pages.product.edit-product')->with([
            'title' => $title,
            'data' => $data,
            'category' => $category
         ]);
      }
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
      $product = Product::findOrFail($id); // Pastikan produk ditemukan

      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'name.max' => 'Nama tidak boleh lebih dari 60 karakter!',
         'code.required' => 'Kode produk wajib diisi!',
         'code.unique' => 'Kode produk sudah terdaftar!',
         'price.required' => 'Harga wajib diisi!',
         'price.numeric' => 'Harga harus berupa angka!',
         'agent_price.required' => 'Harga agen wajib diisi!',
         'agent_price.numeric' => 'Harga agen harus berupa angka!',
         'discount.numeric' => 'Diskon harus berupa angka!',
         'categories.required' => 'Kategori wajib diisi!',
         'categories.*.exists' => 'Kategori tidak ditemukan!',
         'image.image' => 'File harus berupa gambar!',
         'image.mimes' => 'File harus berupa jpeg, png, atau jpg!',
         'image.max' => 'Ukuran file tidak boleh lebih dari 5MB!',
      ];

      $validated = $request->validate([
         'name' => 'required|max:60',
         'code' => ['required', 'max:15', Rule::unique('products')->ignore($product->id)],
         'price' => 'required|numeric',
         'agent_price' => 'required|numeric',
         'discount' => 'nullable|numeric',
         'categories' => 'required|array',
         'categories.*' => 'exists:categories,id',
         'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
      ], $messages);

      // Cek jika ada gambar baru diunggah
      if ($request->hasFile('image')) {
         // Hapus gambar lama jika ada dan tidak null
         if (!empty($product->image) && file_exists(public_path('img/products/' . $product->image))) {
            unlink(public_path('img/products/' . $product->image));
         }

         // Simpan gambar baru
         $image = $request->file('image');
         $imageName = time() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('img/products'), $imageName);
         $validated['image'] = $imageName;
      } else {
         $validated['image'] = $product->image; // Gunakan gambar lama jika tidak ada yang baru
      }

      $validated['price'] = str_replace('.', '', $validated['price']); // Hilangkan titik pada harga
      $validated['agent_price'] = str_replace('.', '', $validated['agent_price']); // Hilangkan titik pada harga agen
      $validated['discount'] = str_replace('.', '', $validated['discount']); // Hilangkan titik pada diskon

      // Update data produk langsung pada objek yang ditemukan
      $product->update([
         'name' => $validated['name'],
         'code' => $validated['code'],
         'price' => $validated['price'],
         'agent_price' => $validated['agent_price'],
         'discount' => $validated['discount'],
         'image' => $validated['image'],
      ]);

      // Update kategori produk
      $product->categories()->sync($request->categories);

      if ($product) {
         return redirect()->route('products')->with('success', 'Produk berhasil diperbarui!');
      } else {
         return redirect()->route('products.edit', $id)->with('error', 'Produk gagal diperbarui!');
      }
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      $product = Product::findOrFail($id);
      $delete = $product->delete();

      if ($delete) {
         return redirect()->route('products')->with('success', 'Produk berhasil dihapus!');
      } else {
         return redirect()->route('products.edit', $id)->with('error', 'Produk gagal dihapus!');
      }
   }
}
