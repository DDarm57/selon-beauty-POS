<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $title = 'Pengeluaran';
      $data = Expense::all()->sortByDesc('id');

      return view('pages.expense.index')->with([
         'title' => $title,
         'data' => $data
      ]);
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      $title = 'Tambah Pengeluaran';
      return view('pages.expense.create-expense')->with(['title' => $title]);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'amount.required' => 'Jumlah wajib diisi!',
         'amount.min' => 'Jumlah harus lebih besar dari 0!',
         'date.required' => 'Tanggal wajib diisi!',
      ];

      $validated = $request->validate([
         'name' => 'required',
         'amount' => 'required|min:1',
         'date' => 'required',
      ], $messages);


      $validated['amount'] = str_replace('.', '', $validated['amount']);

      $create = Expense::create([
         'name' => $validated['name'],
         'description' => $request->description,
         'amount' => $validated['amount'],
         'date' => $validated['date'],
      ]);

      if ($create) {
         return redirect()->route('expenses')->with('success', 'Pengeluaran berhasil ditambahkan!');
      } else {
         return redirect()->route('expenses')->with('error', 'Pengeluaran gagal ditambahkan!');
      }
   }

   public function search(Request $request) {}

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
      $title = 'Edit Pengeluaran';
      $data = Expense::find($id);

      if (!$data) {
         return redirect()->route('expenses')->with('error', 'Pengeluaran tidak ditemukan');
      } else {
         return view('pages.expense.edit-expense')->with([
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
      $data = Expense::find($id);

      $messages = [
         'name.required' => 'Nama wajib diisi!',
         'amount.required' => 'Jumlah wajib diisi!',
         'amount.min' => 'Jumlah harus lebih besar dari 0!',
         'date.required' => 'Tanggal wajib diisi!',
      ];

      $validated = $request->validate([
         'name' => 'required',
         'amount' => 'required|min:1',
         'date' => 'required',
      ], $messages);

      $validated['amount'] = str_replace('.', '', $validated['amount']);

      $data->name = $validated['name'];
      $data->description = $request->description;
      $data->amount = $validated['amount'];
      $data->date = $validated['date'];

      $update = $data->save();

      if ($update) {
         return redirect()->route('expenses')->with('success', 'Pengeluaran berhasil diubah!');
      } else {
         return redirect()->route('expenses')->with('error', 'Pengeluaran gagal diubah!');
      }
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      $data = Expense::find($id);
      if (!$data) {
         return redirect()->route('expenses')->with('error', 'Pengeluaran tidak ditemukan');
      } else {
         $delete = $data->delete();
      }

      if ($delete) {
         return redirect()->route('expenses')->with('success', 'Pengeluaran berhasil dihapus!');
      } else {
         return redirect()->route('expenses')->with('error', 'Pengeluaran gagal dihapus!');
      }
   }
}
