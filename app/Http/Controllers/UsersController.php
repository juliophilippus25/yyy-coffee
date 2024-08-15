<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'password' => 'required|string|min:8',
            'phone' => 'required|min:10|numeric',
            'password_confirmation' => 'required|min:8|same:password',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $user = User::find($id);
        $user->delete();
    }

    public function status(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->status = $request->status;
            $user->save();

            return response()->json(['status' => 200]);
        }

        return response()->json(['status' => 400]);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:users,name,'.$user->id,
            'username' => 'required|min:5|unique:users,username,'.$user->id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'required|min:10|numeric',
            'password_confirmation' => 'nullable|min:8|same:password',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            toast('Something went wrong!','error')->hideCloseButton()->autoClose(3000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->phone = $request->input('phone');
        if($request->input('password')) {
            $user->password= bcrypt(($request->input('password')));
        }

        // Proses upload image
        if($request->file('image')) {
            $oldImage = $user->image;
            $extension = $request->image->getClientOriginalExtension();
            $fileName = time() . '.' .$extension;
            $image = $request->file('image')->storeAs('images/users', $fileName);
            $user->image = $fileName;
            if ($oldImage) {
                Storage::delete('images/users/' . $oldImage);
            }
        }
        $user->update();

        toast('User updated successfully.','success')->hideCloseButton()->autoClose(3000);
        return redirect()->back();

    }
}
