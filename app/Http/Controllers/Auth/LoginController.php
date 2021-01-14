<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo;
//    protected function redirectTo(){
//        if(auth()->user()->role == 'Admin'){
//            return redirect()->route('home');
//        }else{
//            return redirect()->route('supplier.dashboard');
//        }
    //}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(auth()->check() && auth()->user()->role === 'Admin'){
            $this->redirectTo = route('home');
        }else{
            $this->redirectTo = route('supplier.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }
}
