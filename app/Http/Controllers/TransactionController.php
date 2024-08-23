<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
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

        if ($request->ajax()) {
            if ($userRole == 'Admin'){
                $data = Transaction::orderBy('id', 'desc');
            }
            elseif($userRole == 'Staff') {
                $data = Transaction::orderBy('id', 'desc')->where('user_id', $userId);
            }
            return DataTables::of($data)
                ->addColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d F Y');
                })
                ->addColumn('action', function ($data) {
                    return view('transactions.action')->with('data', $data);
                })
                ->make(true);
        }
    
        return view('transactions.index', compact('userId'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        Transaction::create([
            'customer_name' => $request->customer_name,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $transaction = Transaction::find($id);
        $transaction->delete();
    }
}
