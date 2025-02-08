<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $title = 'Dashboard';
      $total_sales = Transaction::whereDate('created_at', today())->sum('total_qty');
      $earnings = Transaction::whereDate('created_at', today())->sum('total_price');
      $expenses = Expense::whereDate('created_at', today())->sum('amount');
      $net_income = $earnings - $expenses;

      return view('pages.dashboard', compact('title', 'total_sales', 'earnings', 'expenses', 'net_income'));
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
      //
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      //
   }
}
