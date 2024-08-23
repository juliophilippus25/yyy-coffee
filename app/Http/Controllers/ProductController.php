<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    
        return view('products.index', compact('category'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // proses upload image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->image->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $image = $request->file('image')->storeAs('images/products', $fileName);
            $image = $fileName;
        } else {
            $image = NULL;
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image
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
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        // Proses upload image
        if($request->file('image')) {
            $oldImage = $product->image;
            $extension = $request->image->getClientOriginalExtension();
            $fileName = time() . '.' .$extension;
            $image = $request->file('image')->storeAs('images/products', $fileName);
            $product->image = $fileName;
            if ($oldImage) {
                Storage::delete('images/products/' . $oldImage);
            }
        }

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
        if (Storage::delete('images/products/' . $product->image)) {
            Product::destroy($id);
        }
    }
}
