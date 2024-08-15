<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('roles', 'Staff')->orderBy('name', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('users.action')->with('data', $data);
                })
                ->make(true);
        }

        return view('users.index');
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buat user baru
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $user = User::find($id);
        if(Auth::user()->id != $id AND $user->roles == 'Admin') {
            $user->delete();
        }
    }

    public function status(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->status = $request->status;
            $user->save();

            return response()->json(['status' => 200, 'message' => 'User status updated successfully.']);
        }

        return response()->json(['status' => 400, 'message' => 'User not found.']);
    }
}
