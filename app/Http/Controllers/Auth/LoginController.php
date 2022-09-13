<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminLogin as AdminLoginRequest;
use Auth;
use App\Models\User;

class LoginController extends Controller
{    
    
    public function redirectUrl()
    {
        return route('dashboard');
    }

    public function showLoginForm()
    {
        if(Auth::check())
            return redirect($this->redirectUrl());
        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request)
    {  
        if(Auth::check())
            return redirect($this->redirectUrl());
            
        $user = User::where('email', $request->email)->admin()->first();
       // To check SuperAdmin dd($user->is_super_admin); 
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return redirect()
            ->back()
            ->withInput()
            ->withError('Credentials do not match.');
        }
        if(!empty($user))
        {   
            if($user->is_active == 0)
            {
                return redirect()
                ->back()
                ->withInput()
                ->withError('Your Account has been deactivated. Plz Contact to Administrator');
            }
            else
            {
                $remember_me = $request->remember == 'on';
                Auth::login($user, $remember_me);
            }
           
        }
            
        return redirect($this->redirectUrl());
    }

    public function logout()
    {
        Auth::check() && Auth::logout();
        return redirect()->route('auth.login');
    }
}
