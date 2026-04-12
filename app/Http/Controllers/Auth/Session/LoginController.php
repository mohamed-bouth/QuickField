<?php

namespace App\Http\Controllers\Auth\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();

            $userRoles = Auth::user()->roles->first()->name;

            if($userRoles === 'super_admin' || $userRoles === 'field_manager' || $userRoles === 'field_guard'){
                return redirect()->route('admin.dashboard.index');
            }
            return redirect()->route('public.dashboard.index');
        }

        return back()->withErrors([
            'email' => 'check your information and try again',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {     
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
