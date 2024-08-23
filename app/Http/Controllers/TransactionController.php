<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::orderBy('id', 'desc');
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return view('transactions.action')->with('data', $data);
                })
                ->make(true);
        }
    
        return view('transactions.index');
    }
}
