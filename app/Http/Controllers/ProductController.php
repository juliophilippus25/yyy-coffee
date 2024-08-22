<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $category = Category::get();
        $product = Product::get();
        if ($request->ajax()) {
            $data = Product::with('category')->orderBy('name', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('category.name', function ($data){
                    return $data->category->name;
                })
                ->addColumn('action', function ($data) {
                    return view('products.action')->with('data', $data);
                })
                ->make(true);
        }
    
        return view('products.index', compact('category', 'product'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function edit(Request $request) {
        $id = $request->id;
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request) {
        $product = Product::find($request->product_id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $product->update();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function show(Request $request) {
        $id = $request->id;
        $product = Product::with('category')->find($id);
        return response()->json($product);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $product = Product::find($id);
        $product->delete();
    }
}
