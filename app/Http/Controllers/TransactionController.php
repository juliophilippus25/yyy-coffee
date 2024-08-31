<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionProduct;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $userRole = Auth::user()->roles;

        $payments = Payment::all();
        $products = Product::all();

        if ($request->ajax()) {
            if ($userRole == 'Admin'){
                $data = Transaction::query();
            }
            elseif($userRole == 'Staff') {
                $data = Transaction::query()->where('user_id', $userId);
            }
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return view('transactions.action',)->with('data', $data);
                })
                ->make(true);
        }
    
        return view('transactions.index', compact('userId', 'payments', 'products'));
    }

    private function generateUniqueTransactionCode()
    {
        $prefix = 'Y3';
        $yearMonth = date('ym');
        $formattedPrefix = $prefix . '-' . $yearMonth . '-';

        $lastTransaction = Transaction::where('transaction_code', 'like', $formattedPrefix . '%')
            ->orderBy('transaction_code', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = (int)substr($lastTransaction->transaction_code, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $formattedPrefix . $newNumber;
    }

    public function store(Request $request) {
        // Validate the request
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'payment_id' => 'required|exists:payments,id',
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
    
        // Generate a unique transaction code
        $transactionCode = $this->generateUniqueTransactionCode();

        $products = $request->input('products');
        // Calculate the total amount
        $totalAmount = 0;
        foreach ($products as $product) {
            $productModel = Product::find($product['id']);
            $totalAmount += $productModel->price * $product['quantity'];
        }
    
        // Create the transaction
        $transaction = Transaction::create([
            'transaction_code' => $transactionCode,
            'customer_name' => $request->customer_name,
            'total_amount' => $totalAmount,
            'payment_id' => $request->payment_id,
            'user_id' => $request->user_id
        ]);

        // Add products to the transaction_products table
        foreach ($products as $product) {
            $productModel = Product::find($product['id']);
    
            TransactionProduct::create([
                'transaction_code_product' => $transactionCode,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_price' => $productModel->price,
                'total_price' => $productModel->price * $product['quantity'],
            ]);
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request) {
        $transactionCode = $request->transaction_code;
        $transaction = Transaction::find($transactionCode);
        $transaction->transactionProducts()->delete();
        $transaction->delete();
    }
}
