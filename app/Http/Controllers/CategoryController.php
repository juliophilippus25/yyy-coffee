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

    public function index()
    {
        return view('categories.index');
    }

    public function fetchAll() {
        $categories = Category::all();
        $output = '';
        if ($categories->count() > 0) {
            $output .= '<table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Category Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($categories as $category) {
                $output .= '<tr>
                <td>' . $category->name . '</td>
                <td>
                  <a href="#" id="' . $category->id . '" class="btn btn-success btn-sm editIcon" title="Edit" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><i class="ti ti-edit"></i></a>
                  <a href="#" id="' . $category->id . '" class="btn btn-danger btn-sm deleteIcon" title="Delete"><i class="ti ti-eraser"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-primary my-3">No data avalaible in the database!</h3>';
        }
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
