<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // $categories = Category::get();
        // return DataTables::of($categories)->make(true);
        // return view('categories.index', compact('categories'));

        if ($request->ajax()) {
            $data = Category::select('name')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('categories.action')->with('products', $data);
            })
            ->make(true);
                
        }
        return view('categories.index');
    }
}
