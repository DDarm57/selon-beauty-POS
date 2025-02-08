<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $title = 'Profile';
      $profile = Profile::first();

      return view('pages.profile.index')->with([
         'title' => $title,
         'data' => $profile
      ]);
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
      //
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
      $data = Profile::find($id);

      // dd($data, $request->all());

      if (!$data) {
         return redirect()->route('profile')->with('error', 'Profile tidak ditemukan');
      } else {
         $message = [
            'name.required' => 'Nama tidak boleh kosong',
            'email.email' => 'Format email salah',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'address.required' => 'Alamat tidak boleh kosong',
            'address.max' => 'Alamat tidak boleh lebih dari 100 karakter',
            'tiktok.max' => 'Tiktok tidak boleh lebih dari 20 karakter',
            'instagram.max' => 'Instagram tidak boleh lebih dari 20 karakter',
            'image.image' => 'File harus berupa gambar!',
            'image.mimes' => 'File harus berupa gambar (jpeg, png, atau jpg)',
            'image.max' => 'Ukuran file tidak boleh lebih dari 5MB!',
         ];

         $validated = $request->validate([
            'name' => 'required',
            'email' => 'email',
            'phone' => 'numeric',
            'address' => 'required|max:100',
            'tiktok' => 'max:20',
            'instagram' => 'max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
         ], $message);

         if ($request->hasFile('image')) {
            // Tentukan path tujuan dan nama file tetap 'logo.png'
            $destinationPath = public_path('img/profile');
            $fileName = 'logo.png';

            // Jika file sudah ada, hapus terlebih dahulu
            $filePath = $destinationPath . '/' . $fileName;
            if (file_exists($filePath)) {
               unlink($filePath);
            }

            // Pindahkan file dengan nama yang sudah ditentukan
            $request->file('image')->move($destinationPath, $fileName);

            // Simpan nama file ke database
            $validated['image'] = $fileName;
         } else {
            $validated['image'] = $data->image;
         }

         $update = $data->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'tiktok' => $validated['tiktok'],
            'instagram' => $validated['instagram'],
            'image' => $validated['image'],
         ]);

         if (!$update) {
            return redirect()->route('profile')->with('error', 'Profile gagal diubah');
         } else {
            return redirect()->route('profile')->with('success', 'Profile berhasil diubah');
         }
      }
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      //
   }
}
