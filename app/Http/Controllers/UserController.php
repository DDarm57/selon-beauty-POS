<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $title = 'Users';
      $data = User::where('role', 2)->get();
      return view('pages.user.index', compact(
         'title',
         'data'
      ));
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      $title = 'Tambah User';
      return view('pages.user.create-user', compact('title'));
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'name.max' => 'Nama tidak boleh lebih dari 30 karakter!',
         'username.required' => 'Username wajib diisi!',
         'username.max' => 'Username tidak boleh lebih dari 15 karakter!',
         'username.unique' => 'Username sudah terdaftar',
         'email.required' => 'Email wajib diisi!',
         'email.email' => 'Email tidak valid',
         'email.max' => 'Email tidak boleh lebih dari 30 karakter!',
         'email.unique' => 'Email sudah terdaftar',
         'password.required' => 'Password wajib diisi!',
         'password.min' => 'Password must be at least 8 characters',
         'password.confirmed' => 'Konfirmasi password tidak sesuai',
      ];

      $validated = $request->validate([
         'name' => 'required|max:30',
         'username' => ['required', 'max:15', Rule::unique('users')->whereNull('deleted_at')],
         'email' => 'required|email|max:30|unique:users',
         'password' => 'required|min:8|confirmed',
      ], $messages);

      $role = 2;

      $user = User::create(
         [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $role,
            'status' => $request->status ? 'active' : 'inactive'
         ]
      );

      if ($user) {
         return redirect()->route('users')->with('success', 'Data berhsil di tambahkan!');
      } else {
         return redirect()->route('users')->with('error', 'Data gagal di tambahkan!');
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
      $title = 'Edit User';
      $data = User::find($id);
      return view('pages.user.edit-user', compact(
         'title',
         'data'
      ));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
      $data = User::find($id);

      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'name.max' => 'Nama tidak boleh lebih dari 30 karakter!',
         'username.required' => 'Username wajib diisi!',
         'username.max' => 'Username tidak boleh lebih dari 15 karakter!',
         'username.unique' => 'Username sudah terdaftar',
         'email.required' => 'Email wajib diisi!',
         'email.email' => 'Email tidak valid',
         'email.max' => 'Email tidak boleh lebih dari 30 karakter!',
         'email.unique' => 'Email sudah terdaftar',
      ];

      $validated = $request->validate([
         'name' => 'required|max:30',
         'username' => ['required', 'max:15', Rule::unique('users')->ignore($data->id)],
         'email' => ['required', 'email', 'max:30', Rule::unique('users')->ignore($data->id)->whereNull('deleted_at')],
      ], $messages);

      $data->name = $validated['name'];
      $data->username = $validated['username'];
      $data->email = $validated['email'];
      $data->status = $request->status ? 'active' : 'inactive';

      if ($data->save()) {
         return redirect()->route('users')->with('success', 'Data berhasil diupdate');
      } else {
         return redirect()->route('users')->with('error', 'Data gagal diupdate');
      }
   }

   public function updateAccount(Request $request, string $id)
   {
      $data = User::find($id);

      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'name.max' => 'Nama tidak boleh lebih dari 30 karakter!',
         'username.required' => 'Username wajib diisi!',
         'username.max' => 'Username tidak boleh lebih dari 15 karakter!',
         'username.unique' => 'Username sudah terdaftar',
         'email.required' => 'Email wajib diisi!',
         'email.email' => 'Email tidak valid',
         'email.max' => 'Email tidak boleh lebih dari 30 karakter!',
         'email.unique' => 'Email sudah terdaftar',
         'old_password.required' => 'Password lama wajib diisi!',
         'password.required' => 'Password baru wajib diisi!',
         'password.min' => 'Password minimal 8 karakter!',
         'password.confirmed' => 'Konfirmasi password tidak sesuai!',
      ];


      if ($request->old_password && $request->password && $request->password_confirmation) {

         $validated = $request->validate([
            'name' => 'required|max:30',
            'username' => ['required', 'max:15', Rule::unique('users')->ignore($data->id)],
            'email' => ['required', 'email', 'max:30', Rule::unique('users')->ignore($data->id)->whereNull('deleted_at')],
            'old_password' => 'min:8',
            'password' => 'min:8|confirmed',

         ], $messages);

         if (!password_verify($request->old_password, $data->password)) {
            return redirect()->route('account', $id)->with('error', 'Password lama tidak sesuai');
         }

         $data->password = bcrypt($validated['password']);
      } else {
         $validated = $request->validate([
            'name' => 'required|max:30',
            'username' => ['required', 'max:15', Rule::unique('users')->ignore($data->id)],
            'email' => ['required', 'email', 'max:30', Rule::unique('users')->ignore($data->id)->whereNull('deleted_at')],
         ], $messages);
      }

      if (Auth::user()->role == 1) {
         $data->name = $validated['name'];
         $data->username = $validated['username'];
         $data->email = $validated['email'];
         if (isset($validated['password'])) {
            $data->password = bcrypt($validated['password']);
         }
      } else if (Auth::user()->role == 2) {
         $data->username = $validated['username'];
         $data->email = $validated['email'];
         if (isset($validated['password'])) {
            $data->password = bcrypt($validated['password']);
         }
      }


      if ($data->save()) {
         return redirect()->route('account', $id)->with('success', 'Akun berhasil diupdate');
      } else {
         return redirect()->route('account', $id)->with('error', 'Akun gagal diupdate');
      }
   }

   public function resetPassword(string $id)
   {
      $user = User::find($id);
      $user->password = bcrypt($user->default_password);
      if ($user->save()) {
         return redirect()->route('users.edit', $user->id)->with('success', 'Password berhasil direset');
      } else {
         return redirect()->route('users.edit', $user->id)->with('error', 'Password gagal direset');
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
