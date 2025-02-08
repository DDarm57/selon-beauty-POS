<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $title = 'Kategori';
      $data = Category::all();
      return view('pages.category.index')->with([
         'title' => $title,
         'data' => $data
      ]);
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      $title = 'Tambah Kategori';
      return view('pages.category.create-category')->with([
         'title' => $title
      ]);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'name.max' => 'Nama tidak boleh lebih dari 30 karakter!',
         'name.unique' => 'Kategori sudah terdaftar',
      ];

      $validated = $request->validate([
         'name' => ['required', 'max:30', Rule::unique('categories')->whereNull('deleted_at')],
      ], $messages);

      $category = Category::create([
         'name' => $validated['name'],
      ]);

      if ($category) {
         return redirect()->route('categories.create')->with('success', 'Kategori berhasil ditambahkan');
      } else {
         return redirect()->route('categories.create')->with('error', 'Kategori gagal ditambahkan');
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
      $title = 'Edit Kategori';
      $data = Category::find($id);

      if (!$data) {
         return redirect()->route('categories')->with('error', 'Kategori tidak ditemukan');
      } else {
         return view('pages.category.edit-category')->with([
            'title' => $title,
            'data' => $data
         ]);
      }
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'name.max' => 'Nama tidak boleh lebih dari 30 karakter!',
         'name.unique' => 'Kategori sudah terdaftar',
      ];

      $validated = $request->validate([
         'name' => ['required', 'max:30', Rule::unique('categories')->ignore($id)->whereNull('deleted_at')],
      ], $messages);


      $category = Category::where('id', $id)->update([
         'name' => $validated['name'],
      ]);

      if ($category) {
         return redirect()->route('categories')->with('success', 'Kategori berhasil diubah');
      } else {
         return redirect()->route('categories.edit', $id)->with('error', 'Kategori gagal diubah');
      }
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      $category = Category::where('id', $id)->first();
      $delete = $category->delete(); // Soft Delete

      if (!$delete) {
         return redirect()->route('categories')->with('error', 'Kategori gagal dihapus');
      } else {
         return redirect()->route('categories')->with('success', 'Kategori berhasil dihapus');
      }
   }
}
