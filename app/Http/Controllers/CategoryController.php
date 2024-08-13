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
        if ($request->ajax()) {
            $data = Category::orderBy('name', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('categories.action')->with('data', $data);
                })
                ->make(true);
        }
    
        return view('categories.index');
    }


    public function store(Request $request) {
        $category = ['name' => $request->name];
        Category::create($category);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function edit(Request $request) {
        $id = $request->id;
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request) {
        $category = Category::find($request->category_id);
 
        $categoryData = ['name' => $request->name];
 
        $category->update($categoryData);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $category = Category::find($id);
        $category->delete();
    }
}