<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Transient;

class AjaxController extends Controller
{
    //
    public function getProduct(Request $request)
    {
        $code = $request->code;

        $product = Product::where('code', $code)->first();

        if (!$product) {
            $data = [
                'status' => 'error',
                'message' => 'Product not found'
            ];

            return response()->json($data);
        }

        $categoryProduct = Category::join('product_category', 'categories.id', '=', 'product_category.category_id')
            ->where('product_category.product_id', $product->id)
            ->get();

        $data = [
            'data' => $product,
            'status' => 'success',
            'categories' => $categoryProduct,
        ];

        return response()->json($data);
    }

    public function getTransactionByDate(Request $request)
    {

        $getTransaction = Transaction::join('users', 'transactions.user_id', '=', 'users.id')->select('transactions.*', 'transactions.id as id_transaction', 'users.name')
            ->whereBetween('transactions.created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ])
            ->get();

        if (!$getTransaction) {
            $data = [
                'status' => 'error',
                'message' => 'Transaction not found'
            ];

            return response()->json($data);
        }

        $data_transaction = [];

        $no = 1;
        foreach ($getTransaction as $item) {
            $data_transaction[] = [
                'no' => $no++,
                'transaction_code' => $item->transaction_code,
                'dateandtime' => date('d-m-Y', strtotime($item->created_at)) . ' / ' . date('H:i', strtotime($item->created_at)),
                'name_cashier' => $item->name,
                'total_qty' => $item->total_qty,
                'total_price' => $item->total_price,
                'pay' => $item->pay,
                'change' => $item->change,
            ];
        }

        $data = [
            'data' => $data_transaction,
            'search' => $request->start_date . ' - ' . $request->end_date,
            'status' => 'success',
        ];

        return response()->json($data);
    }
}
