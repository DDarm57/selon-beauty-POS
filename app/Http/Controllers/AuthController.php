<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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
      $title = 'Edit Akun';
      $user = User::find($id);
      if (!$user) {
         return redirect()->route('error')->with('error', 'Data tidak ditemukan');
      } else if ($user->id !== Auth::id()) {
         return redirect()->route('error')->with('error', 'Anda tidak memiliki akses');
      } else {
         return view('pages.auth.account')->with(['title' => $title, 'data' => $user]);
      }
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      //
   }

   public function login(Request $request)
   {
      $message = [
         'required' => 'Kolom :attribute tidak boleh kosong',
         'min' => 'Kolom :attribute minimal :min karakter',
      ];

      $request->validate([
         'login' => 'required',   // Login bisa berupa email atau username
         'password' => 'required|min:8',
      ], $message);

      // Cek apakah yang dimasukkan adalah email atau username
      $user = User::where('email', $request->login)
         ->orWhere('username', $request->login)
         ->first();

      if ($user && $user->status === 'active' && Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
         $request->session()->regenerate();

         return redirect()->route('dashboard')->with('success', 'Login berhasil');
      }

      return redirect()->route('login')->with(['error' => 'Email/Username atau password salah!']);
   }

   // Proses logout
   public function logout(Request $request)
   {
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect('/login')->with('success', 'Logout berhasil');
   }
}
