<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Models\Stock;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//    return view('welcome');
// });

// Route::get('/', function () {
//    return view('dashboard');
// });
Route::middleware('guest')->group(function () {
   Route::get('/error', function () {
      return view('error.404');
   })->name('error');

   Route::get('/login', function () {
      return view('pages.auth.login');
   })->name('login');

   Route::post('/user-login', [AuthController::class, 'login'])
      ->name('user.login');
});


// route untuk admin & kasir
Route::middleware('auth')->group(function () {
   Route::get('/logout', [AuthController::class, 'logout'])
      ->name('logout');

   Route::get('/account/{id}', [AuthController::class, 'edit'])
      ->name('account');

   Route::put('/account/account-update/{id}', [UserController::class, 'updateAccount'])
      ->name('account.update');

   Route::get('/', [DashboardController::class, 'index'])
      ->name('dashboard');

   // Ajax Request
   Route::post('/getProduct', [AjaxController::class, 'getProduct'])->name('getProduct');

   Route::get('/transaction_history', [TransactionController::class, 'transaction_history'])
      ->name('transaction_history');

   Route::get('/transaction_details/{id}', [TransactionController::class, 'transaction_details'])
      ->name('transaction_details');

   Route::get('/transaction/delete/{id}', [TransactionController::class, 'destroy'])
      ->name('transaction.delete');

   Route::get('/transaction/print_notes/{id}', [TransactionController::class, 'print_notes'])
      ->name('transaction.print_notes');

   Route::post('/getTransactionByDate', [AjaxController::class, 'getTransactionByDate'])
      ->name('getTransactionByDate');
});

// route hanya untuk admin
Route::middleware('auth', 'role:1')->group(function () {
   Route::get('/users', [UserController::class, 'index'])
      ->name('users');

   Route::get('/users/create', [UserController::class, 'create'])
      ->name('users.create');

   Route::post('/users/store', [UserController::class, 'store'])
      ->name('users.store');

   Route::get('/users/edit/{id}', [UserController::class, 'edit'])
      ->name('users.edit');

   Route::put('/users/update/{id}', [UserController::class, 'update'])
      ->name('users.update');

   Route::get('/users/reset/{id}', [UserController::class, 'resetPassword'])
      ->name('users.reset');


   // route for category management
   Route::get('/categories', [CategoryController::class, 'index'])
      ->name('categories');

   Route::get('/categories/create', [CategoryController::class, 'create'])
      ->name('categories.create');

   Route::post('/categories/store', [CategoryController::class, 'store'])
      ->name('categories.store');

   Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])
      ->name('categories.edit');

   Route::put('/categories/update/{id}', [CategoryController::class, 'update'])
      ->name('categories.update');

   Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy'])
      ->name('categories.destroy');

   // route for product management
   Route::get('/products', [ProductController::class, 'index'])
      ->name('products');

   Route::get('/products/create', [ProductController::class, 'create'])
      ->name('products.create');

   Route::post('/products/store', [ProductController::class, 'store'])
      ->name('products.store');

   Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

   Route::get('/products/edit/{id}', [ProductController::class, 'edit'])
      ->name('products.edit');

   Route::put('/products/update/{id}', [ProductController::class, 'update'])
      ->name('products.update');

   Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])
      ->name('products.destroy');

   Route::post('/products/add-stock', [StockController::class, 'store'])
      ->name('products.add-stock');

   Route::put('/products/update-stock/{id}', [StockController::class, 'update'])
      ->name('products.update-stock');

   Route::delete('/products/delete-stock/{id}', [StockController::class, 'destroy'])
      ->name('products.delete-stock');

   Route::get('/stocks', [StockController::class, 'index'])
      ->name('stocks');

   // route for expense management
   Route::get('/expenses', [ExpenseController::class, 'index'])
      ->name('expenses');

   Route::get('/expense/create', [ExpenseController::class, 'create'])
      ->name('expenses.create');

   Route::post('/expense/store', [ExpenseController::class, 'store'])
      ->name('expenses.store');

   Route::get('/expenses/edit/{id}', [ExpenseController::class, 'edit'])
      ->name('expenses.edit');

   Route::put('/expenses/update/{id}', [ExpenseController::class, 'update'])
      ->name('expenses.update');

   Route::delete('/expenses/destroy/{id}', [ExpenseController::class, 'destroy'])
      ->name('expenses.destroy');

   Route::get('/profile', [ProfileController::class, 'index'])
      ->name('profile');

   Route::put('/profile/update/{id}', [ProfileController::class, 'update'])
      ->name('profile.update');
});

// Route hanya untuk karyawan kasir
Route::middleware('auth', 'role:2')->group(function () {
   Route::get('/transaction', [TransactionController::class, 'transaction'])
      ->name('transaction');

   Route::post('/transaction/store', [TransactionController::class, 'store'])
      ->name('transaction.store');
});
