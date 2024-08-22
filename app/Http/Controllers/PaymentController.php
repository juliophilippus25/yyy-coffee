<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::orderBy('name', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('payments.action')->with('data', $data);
                })
                ->make(true);
        }
    
        return view('payments.index');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:payments,name'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        Payment::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function edit(Request $request) {
        $id = $request->id;
        $payment = Payment::find($id);
        return response()->json($payment);
    }

    public function update(Request $request) {
        $payment = Payment::find($request->payment_id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $payment->name = $request->input('name');

        $payment->update();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $payment = Payment::find($id);
        $payment->delete();
    }
}
