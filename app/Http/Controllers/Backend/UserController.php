<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $data['users'] = User::all();
        return view('backend.user.view_user', $data);
    }

    public function add(){
        return view('backend.user.add_user');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'role' => 'required|',
            'name' => 'required|string|max:124',
            'email' => 'required|email|unique:users',
            'mobile' => 'unique:users',
            'image' => 'image',
            'password'=>'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();

        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
        session()->flash('type', 'success');
        session()->flash('message', 'User created successfully');
        return redirect()->route('users.view');

    }

    public function edit($id){
        $data['user'] = User::find($id);
        return view('backend.user.edit', $data);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'role' => 'required|',
            'name' => 'required|string|max:124',
            'email' => "required|email|unique:users,email,$id",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);

        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        session()->flash('type', 'success');
        session()->flash('message', 'User updated successfully');
        return redirect()->route('users.view');

    }

    public function delete($id){
        $user = User::find($id);

        $user->delete();
        session()->flash('type', 'success');
        session()->flash('message', 'User deleted successfully');
        return redirect()->route('users.view');

    }
}
