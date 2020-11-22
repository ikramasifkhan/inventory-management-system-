<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $data['user'] = User::find($id);
        return view('backend.profile.view', $data);
    }

    public function edit(){
        $id = Auth::user()->id;
        $data['user'] = User::find($id);
        return view('backend.profile.edit', $data);
    }

    public function update(Request $request){
        $id = Auth::user()->id;
        $user = User::find($id);
        $user_id = $user->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:124',
            'email' => "required|email|unique:users,email,$user_id",
            'mobile' => "unique:users,mobile,$user_id",
            'address'=>'required|string|max:255',
            'gender'=>'required',
            'image' => 'image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->gender = $request->gender;
        if($request->file('image')){
            $image = $request->file('image');
            @unlink(public_path('uploads/user_image/'.$user->image));
            $filename = $request->name.$request->mobile.$image->getClientOriginalName();
            $image->move(public_path('uploads/user_image/'), $filename);
            $user->image = $filename;
        }
        $user->save();
        session()->flash('type', 'success');
        session()->flash('message', 'Your profile updated successfully');
        return redirect()->route('profiles.view');
    }

    public function password_view(){
        return view('backend.profile.password_change');
    }

    public function password_change(Request $request){
        $validator = Validator::make($request->all(), [
            'new_pasword'=>'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if(auth()->attempt(['id'=>auth()->user()->id, 'password'=>$request->current_password])){
            $id = auth()->user()->id;
            $user = User::find($id);

            $user->password = bcrypt($request->new_pasword);
            $user->save();
            session()->flash('type', 'success');
            session()->flash('message', 'Your password change successfully');
            return redirect()->route('profiles.view');

        }
        session()->flash('type', 'danger');
        session()->flash('message', 'Your current password does not match our records');
        return redirect()->back();
    }
}
