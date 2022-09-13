<?php

namespace App\Http\Controllers\Auth;

//use AWS\CRT\HTTP\Request;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\ForgetPassword\ResetPasswordRequest;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetPasswordForm(Request $request)
    {
        $token = $request->token;
        return view('admin.auth.passwords.reset',compact('token'));
    }

    public function submitResetPasswordForm(ResetPasswordRequest $request)
    {
      
        $password = $request->password;
        $token = $request->token;
    $tokenData = DB::table('password_resets')
                ->where('token', $token)
                ->first();
    if (!$tokenData) {
        return redirect()->back()->withErrors(['token' => 'Token expired or doesnt exist']);
    }
    $user = User::where('email', $tokenData->email)->first();
    // Redirect the user back if the email is invalid
    if (!$user) 
    return redirect()->back()->withErrors(['email' => 'Email not found']);
    //Hash and update the new password
    $user->password = bcrypt($password);
    $user->update(); //or $user->save();

    //login the user immediately they change password successfully
    //Auth::login($user);

    //Delete the token
    DB::table('password_resets')->where('email', $user->email)
    ->delete();
    

  

    
// Redirect the user back to the password reset request form if the token is invalid
    // if (!$otpData) {
        
    // }
    

    

    //Send Email Reset Success Email
    return redirect()->route('auth.login')->with('success', 'Password has been Updated successfully ');


    }



}
