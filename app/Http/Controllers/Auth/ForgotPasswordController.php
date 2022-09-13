<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Mail\forgetPasswordEmail;
use App\Http\Controllers\Controller;

use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showForgetPasswordForm()
    {
        return view('admin.auth.passwords.email');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $rules = array(
            'email' => 'required|email|exists:users'
        );

        $errors = Validator::make($request->all(), $rules);

        if ($errors->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $errors->errors()->all()
            ], 400);
        }

        $email_id = $request->email;

        $user = User::whereEmail($email_id)->admin()->active()->first();

        if ($user) {
            $otp = rand(1000, 9999);

            DB::table('password_resets')
                ->insert([
                    'email' => $email_id,
                    'token' => Str::random(60),
                    'otp' => $otp,
                    'generate_at' => Carbon::now(),
                    'created_at' => Carbon::now()
                ]);

                try {
                    Mail::to($user->email)->send(new forgetPasswordEmail($user, $otp));
                } catch (\Exception $e) {
                    Log::error($e);
                }

            if (Mail::failures()) {
                return response()->json(['errors' => 'Mail is not working']);
            }
        }

        return response()->json(['status' => true, 'success' => 'OTP has been sent to Your Mail Id.', 'user_email' => $user->email]);
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->otp;

        $otpData = DB::table('password_resets')
            ->where('otp', trim($otp))
            ->first();

        if (!empty($otpData)) {
            $totalDuration = Carbon::parse($otpData->generate_at)
                ->diffInMinutes(Carbon::now());

            if ($totalDuration > config('common.otp_valid_min')) {
                return redirect()
                    ->back()
                    ->with(['error' => 'OTP Expired']);
            } else {
                return redirect()
                    ->route('auth.reset.password', ['token' => $otpData->token])
                    ->with('success', 'OTP verified');
            }
        } else {
            return redirect()->back()->with(['error' => 'OTP Does Not Exist']);
        }
    }
}
