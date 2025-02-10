<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Profile;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
   //
   public function transaction()
   {
      $getProduct = Product::all();

      $data = [
         'title' => 'Transaksi Karyawan',
         'transaction_code' => 'TRX-' . date('ymd') . mt_rand(10000, 99999),
         'products' => $getProduct
      ];

      return view('pages.transaction.transaction', $data);
   }

   public function store(Request $request)
   {
      $total_product = count($request->product_id);

      $transaction_detail = [];

      $total_qty = 0;

      for ($i = 0; $i < $total_product; $i++) {
         $transaction_detail[] = [
            'product_id' => $request->product_id[$i],
            'price_product' => $request->price_product[$i],
            'discount' => $request->discount[$i],
            'qty' => $request->qty[$i],
            'total_product_price' => $request->total_product_price[$i],
            'total_product_price_after_discount' => $request->total_product_price_after_discount[$i],
         ];

         $total_qty += $request->qty[$i];
      }

      $transaction_data = [
         'transaction_code' => $request->transaction_code,
         'user_id' => auth()->user()->id,
         // 'customer_name' => $request->customer_name,
         'total_qty' => $total_qty,
         'transaction_detail' => $transaction_detail,
         'total_price' => $request->total_price,
         'total_price_after_discount' => $request->total_price_after_discount,
         'pay' => str_replace('.', '', $request->pay),
         'change' => $request->change,
         'payments' => $request->payments,
         'transaction_tipe' => $request->transaction_tipe
      ];

      // dd($transaction_data);

      $transaction = Transaction::create($transaction_data);

      foreach ($transaction_detail as $td) {
         TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $td['product_id'],
            'price_product' => $td['price_product'],
            'discount' => $td['discount'],
            'qty' => $td['qty'],
            'total_product_price' => $td['total_product_price'],
            'total_product_price_after_discount' => $td['total_product_price_after_discount'],
         ]);

         $getProduct = Product::findOrfail($td['product_id']);

         $getProduct->update([
            'stock' => $getProduct->stock - $td['qty']
         ]);
      }

      return redirect()->route('transaction.print_notes', $transaction->id)->with('success', 'Transaksi berhasil disimpan');
      //return redirect()->route('transaction')->with('success', 'Transaksi berhasil disimpan');
   }

   public function print_notes($id)
   {
      $getTransaction = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
         ->select('transactions.*', 'transactions.id as id_transaction', 'users.name')
         ->where('transactions.id', $id)
         ->first();

      $getTransactionDetails = TransactionDetail::join('products', 'transaction_details.product_id', '=', 'products.id')
         ->select('transaction_details.*', 'transaction_details.discount as product_discount', 'products.*')
         ->where('transaction_id', $id)
         ->get();

      $getProfileStore = Profile::first();

      $data = [
         'transaction' => $getTransaction,
         'transaction_details' => $getTransactionDetails,
         'profile_store' => $getProfileStore,
         'role' => Auth::user()->role
      ];

      return view('pages.transaction.print_notes', $data);
   }

   public function transaction_history()
   {
      $start_date = Carbon::today()->subWeek()->toDateString(); // Mundur 1 minggu
      $end_date = Carbon::today()->toDateString();

      if (isset($_GET['start_date']) || isset($_GET['end_date'])) {
         $start_date = $_GET['start_date'];
         $end_date = $_GET['end_date'];
      }

      $getTransaction = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
         ->select('transactions.*', 'transactions.id as id_transaction', 'users.name')
         ->whereBetween('transactions.created_at', [
            Carbon::parse($start_date)->startOfDay(),
            Carbon::parse($end_date)->endOfDay()
         ])
         ->get();
      // dd($start_date, $end_date);
      // dd($getTransaction);

      $data = [
         'title' => 'Riwayat Transaksi',
         'transactions' => $getTransaction,
         'search_form' => ['start_date' => $start_date, 'end_date' => $end_date]
      ];

      return view('pages.transaction.transaction_history', $data);
   }

   public function transaction_details($id)
   {

      $getTransaction = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
         ->select('transactions.*', 'transactions.id as id_transaction', 'users.name')
         ->where('transactions.id', $id)
         ->first();


      $getTransactionDetails = TransactionDetail::join('products', 'transaction_details.product_id', '=', 'products.id')
         ->select('transaction_details.*', 'transaction_details.discount as product_discount', 'products.*')
         ->where('transaction_id', $id)
         ->get();

      // dd($getTransactionDetails);

      $data = [
         'title' => 'Detail Transaksi',
         'transaction' => $getTransaction,
         'transaction_details' => $getTransactionDetails
      ];

      return view('pages.transaction.transaction_details', $data);
   }

   public function destroy($id)
   {
      $getTransaction = Transaction::findOrfail($id);

      $getTransactionDetails = TransactionDetail::where('transaction_id', $id)->get();

      foreach ($getTransactionDetails as $td) {
         $getProduct = Product::findOrfail($td->product_id);

         $getProduct->update([
            'stock' => $getProduct->stock + $td->qty
         ]);

         $td->delete();
      }

      $getTransaction->delete();

      return redirect()->route('transaction_history')->with('success', 'Transaksi berhasil dihapus, dan stok produk dikembalikan');
   }
}
