<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Traits\SMSTrait;
use App\Http\Traits\NotificationTrait;
use App\Http\Controllers\Controller;

use App\Models\Farmer;
use App\Models\FarmerDevice;
use App\Models\WrongAttemptPin;

use Carbon\Carbon;

/**
 * @group  Auth
 *
 * APIs for managing Auth
 */

class AuthController extends Controller
{
    use SMSTrait;
    use NotificationTrait;

    /**
     * Login
     *  
     * @bodyParam  username string required The username field is required.'  
     * @bodyParam  pin int,digits:6 required The pin field is required.
     * @bodyParam  fcm_token string required The fcm_token field is required.
     * @bodyParam  device_token string required The device_token field is required.
     * @bodyParam  device_type string required The device_type field is required.
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Login",
                                    "timestamp": "2022-01-13 08:54:29"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The username field is required."
                                }
                            }
                        }
     * @response  404  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Login",
                                    "timestamp": "2022-01-13 08:55:12"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "User not available"
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Login",
                                "timestamp": "2022-01-13 09:24:42"
                            },
                            "body": {
                                "status": true,
                                "msg": "You are logged in successfully",
                                "data": {
                                    "name": "Ajam",
                                    "username": "webolajam",
                                    "company_name": "Webol",
                                    "registration_number": "good123",
                                    "business_partner_id": null,
                                    "email": "mohd@webol.co.uk",
                                    "dialing_code": "+91",
                                    "phone": "7388337731",
                                    "address": "India",
                                    "country_id": 1,
                                    "aditional_details": null,
                                    "user_type": "Producer",
                                    "block_login_time": null,
                                    "is_news_sms": 0,
                                    "is_marketing_sms": 0,
                                    "is_bids_received_sms": 0,
                                    "is_news_notification": 0,
                                    "is_marketing_notification": 0,
                                    "is_bids_received_notification": 0,
                                    "mobile_verified": 0,
                                    "last_login_at": null,
                                    "reason": null,
                                    "is_suspend": 0,
                                    "status": 1,
                                    "language": "en",
                                    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImMxODQ5OWFiOTQ3ZTljMTJiMWY4ZGM4MDUyOTQ3MDQ2NGYwZjM3ZmNkYjg2ZjhiOTE1N2RlYmZlNTczMmEwOTM0M2Q5OWE4OTEzYTc3ZTRkIn0.eyJhdWQiOiIxIiwianRpIjoiYzE4NDk5YWI5NDdlOWMxMmIxZjhkYzgwNTI5NDcwNDY0ZjBmMzdmY2RiODZmOGI5MTU3ZGViZmU1NzMyYTA5MzQzZDk5YTg5MTNhNzdlNGQiLCJpYXQiOjE2NDIwNDYwODIsIm5iZiI6MTY0MjA0NjA4MiwiZXhwIjoxNjczNTgyMDgyLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.OWdt7sVrR-H_oSSA-p6cFfA-goADhO7wiXJPkAkuek0Aua89_fYdIU31IAnLeMIGoMPL355MGFJtE093XWQJ24KIkptENWgAB0FdO67Z4Lj-u4VUJEwGLZZ_YRr860eVE4nhae097tjHn_jfHWWRs2KZXgfTtPJDXy58AnLoRNRVvBSsKZoBKBBRVvNTzIHGxQsVoTttO1gFBi_h3ElVLFVG9M0utO-rFMFrhgKpgcqpQ94KSSJTVaAhjSGnQXLwk1biLyZawSOxD-7Mkw9xFgcVsz6-OCePGRfW_0Glcll77OPbF0ZR01Xnmo2l7S8Csf2RDUI_VWcK9wvYimcJt3Pv8oB_XObemF-Qs2ZDn5nR7CUzCO7akd3-gfQMQcUUfz2EVLGNBRfTXXEWDzIJsh3qHA94ikrkDR8oJeRZDIbQ_xcC-XRInB5H9HOfIBmD1qYpA2URmDc5txIfN9nxtmthjQKXy6kR6WG8kvJXGyjEH9OAk6tfEchyWvKtZYJuEjv1krdvuT0UIgut62VFNBrlO9KhS_mMBWgHGNHb3QGsgKAs0u6qQX-cOjLOi9TcjLW30KDlnwhM128Pl88wVOy1I3BCXD8GxS0jeBjAm4LVpE1nv3JD81xDO8V-mRZTegdf7p17rbv3IRIwyUcjZpC-9eDG8FkYcYUGMk0nFcA",
                                    "fcm_token": "fcm_tokenaa",
                                    "device_token": "dsds11"
                                }
                            }
                        }
                    }
     */


    public function login(Request $request)
    {
        $serviceName = 'Login';

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'pin' => 'required|digits:6|numeric',
            'fcm_token' => 'required',
            'device_token' => 'required',
            'device_type' => 'required',
        ], [
            'username.required' => trans('app_auth_error.username.required'),
            'pin.required' => trans('app_auth_error.pin.required'),
            'pin.digits' => trans('app_auth_error.pin.digits'),
            'pin.numeric' => trans('app_auth_error.pin.numeric'),
            'pin.fcm_token' => trans('app_auth_error.pin.fcm_token'),
            'pin.device_token' => trans('app_auth_error.pin.device_token'),
            'pin.device_type' => trans('app_auth_error.pin.device_type'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $data = $validator->validated();

        $farmer = Farmer::with('country')->whereUsername($data['username'])->orWhere('email',$data['username'])->first();
       
        if (!$farmer) {
            return apiFormatResponse(trans('app_auth.user_not_found'), null, $serviceName, false, 404);
        } else if (!is_null($farmer->block_login_time) && $farmer->block_login_time >= Carbon::now()) {
            return apiFormatResponse(trans('app_auth.block_login', ['time' => config('common.block_login_attempt_time')]), null, $serviceName, false, 449);
        } else if ($farmer->is_suspend) {

            return apiFormatResponse(trans('app_auth.suspend_account'), null, $serviceName, false, 401);

        } else if (!Hash::check($data['pin'], $farmer->pin)) {

            $from = Carbon::now()->subMinutes(config('common.block_login_attempt_time'))->toDateTimeString();
            $to = Carbon::now();
            $wrong_attempt_time =  WrongAttemptPin::where('farmer_id', $farmer->id)->whereBetween('attempt_time', [$from, $to])->get();

            if ($wrong_attempt_time->count() >= 3) {
                $farmer->block_login_time = Carbon::now()->addMinutes(config('common.block_login_attempt_time'))->toDateTimeString();
                $farmer->save();
            } else {
                WrongAttemptPin::create([
                    'farmer_id' => $farmer->id,
                    'attempt_time' => Carbon::now(),
                ]);
            }
            return apiFormatResponse(trans('app_auth.invalid_pin'), null, $serviceName, false, 401);
        } else if (!$farmer->status) {
            return apiFormatResponse(trans('app_auth.account_unapproved'), null, $serviceName, false, 401);
        }

        $data = $farmer->toArray();
        $data['language'] = $farmer->country->language;
        $data['abbreviation'] = $farmer->country->abbreviation;
        $data['time_zone'] = $farmer->country->time_zone;
        $data['token'] = $farmer->createToken(env('APP_NAME', 'GoodMills'))->accessToken;

        unset($data['id']);
        unset($data['country']);

        $farmer->block_login_time = null;
        $farmer->last_login_at = now()->toDateTimeString();
        $farmer->save();

        WrongAttemptPin::where('farmer_id', $farmer->id)->delete();


        $farmer_device = FarmerDevice::whereFarmerId($farmer->id)->first();
        
        if ($farmer_device) {
            $farmer_device->fcm_token = $request->fcm_token;
            $farmer_device->device_token = $request->device_token;
            $farmer_device->device_type = $request->device_type;
            $farmer_device->save();
        } else {
            $farmer_device = FarmerDevice::create([
                'farmer_id' => $farmer->id,
                'fcm_token' => $request->fcm_token,
                'device_token' => $request->device_token,
                'device_type' => $request->device_type,
            ]);
        }       

        $data['fcm_token'] = $farmer_device->fcm_token;
        $data['device_token'] = $farmer_device->device_token;

        return apiFormatResponse(trans('app_auth.login_success'), $data, $serviceName, true);
    }

    /**
     * Signup
     * 
     * @bodyParam  name string required The name field is required.
     * @bodyParam  username string,min:2,max:20,alpha_num required The username field is required.'
     * @bodyParam  email email,min:2,max:30, required The email field is required.'
     * @bodyParam  company_name string,min:2,max:30, required The company_name field is required.'
     * @bodyParam  registration_number string,alpha_num,max:12, 
     * @bodyParam  pin int,digits:6 required The pin field is required.
     * @bodyParam  confirm_pin int,digits:6,same:pin required The confirm_pin field is required.
     * @bodyParam  dialing_code string,regex:/^\+(\d{1}\-)?(\d{1,3})$/ required The dialing_code field is required.
     * @bodyParam  phone in,digits_between:2,20 required The phone field is required.
     * @bodyParam  address string,min:2,max:30 required The address field is required.
     * @bodyParam  country_id int required The country_id field is required.
     * @bodyParam  user_type string,min:2,max:30 required The address field is required.
     * @bodyParam  fcm_token string required The fcm_token field is required.
     * @bodyParam  device_token string required The device_token field is required.
     * @bodyParam  device_type string required The device_type field is required.
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Signup",
                                    "timestamp": "2022-01-13 08:51:53"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The name field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Signup",
                                "timestamp": "2022-01-13 08:52:34"
                            },
                            "body": {
                                "status": true,
                                "msg": "Registration has been completed successfully and your account is under review",
                                "data": []
                            }
                        }
                    }
     */

    public function signup(Request $request)
    {
        $serviceName = 'Signup';

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:30',
            'username' => 'required|min:2|max:20|alpha_num|unique:farmers,username',
            'email' => 'required|min:2|max:30|unique:farmers,email',
            'company_name' => 'required|min:2|max:30',
            'registration_number' => 'nullable|alpha_num|max:12',
            'pin' => 'required|digits:6',
            'confirm_pin' => 'required|digits:6|required_with:pin|same:pin',
            'dialing_code' => 'required|regex:/^\+(\d{1}\-)?(\d{1,3})$/',
            'phone' => 'required|integer|digits_between:2,20',
            'address' => 'required|min:2|max:30',
            'country_id' => 'required',
            'user_type' => 'required|min:2|max:30',
            // 'fcm_token' => 'required',
            // 'device_token' => 'required',
            // 'device_type' => 'required',

        ], [
            'name.required' => trans('app_auth_error.name.required'),
            'name.min' => trans('app_auth_error.name.min'),
            'name.max' => trans('app_auth_error.name.max'),
            'username.required' => trans('app_auth_error.username.required'),
            'username.min' => trans('app_auth_error.username.min'),
            'username.max' => trans('app_auth_error.username.max'),
            'username.alpha_num' => trans('app_auth_error.username.alpha_num'),
            'username.unique' => trans('app_auth_error.username.unique'),
            'email.required' => trans('app_auth_error.email.required'),
            'email.min' => trans('app_auth_error.email.min'),
            'email.max' => trans('app_auth_error.email.max'),
            'email.unique' => trans('app_auth_error.email.unique'),
            'company_name.required' => trans('app_auth_error.company_name.required'),
            'company_name.min' => trans('app_auth_error.company_name.min'),
            'company_name.max' => trans('app_auth_error.company_name.max'),
            'pin.required' => trans('app_auth_error.pin.required'),
            'pin.digits' => trans('app_auth_error.pin.digits'),
            'confirm_pin.required' => trans('app_auth_error.confirm_pin.required'),
            'confirm_pin.same' => trans('app_auth_error.confirm_pin.same'),
            'dialing_code.required' => trans('app_auth_error.dialing_code.required'),
            'dialing_code.regex' => trans('app_auth_error.dialing_code.regex'),
            'phone.required' => trans('app_auth_error.phone.required'),
            'phone.integer' => trans('app_auth_error.phone.integer'),
            'phone.digits_between' => trans('app_auth_error.phone.digits_between'),
            'address.required' => trans('app_auth_error.address.required'),
            'address.min' => trans('app_auth_error.address.min'),
            'address.max' => trans('app_auth_error.address.max'),
            'country_id.required' => trans('app_auth_error.country_id.required'),
            'user_type.required' => trans('app_auth_error.user_type.required'),
            'user_type.min' => trans('app_auth_error.user_type.min'),
            'user_type.max' => trans('app_auth_error.user_type.max'),
            // 'pin.fcm_token' => trans('app_auth_error.pin.fcm_token'),
            // 'pin.device_token' => trans('app_auth_error.pin.device_token'),
            // 'pin.device_type' => trans('app_auth_error.pin.device_type'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $data = $validator->validated();
        unset($data['confirm_pin']);
        $data['pin'] = Hash::make($request['pin']);

        $farmer = Farmer::create($data);
        $farmer->countries()->attach($data['country_id'], ['status' => 1], false);

        // FarmerDevice::create([
        //     'farmer_id' => $farmer->id,
        //     'fcm_token' => $data['fcm_token'],
        //     'device_type' => $data['device_type'],
        //     'device_token' => $data['device_token'],
        // ]);

        return apiFormatResponse(trans('app_auth.signup_success'), [], $serviceName);
    }

    /**
     * Forgot
     *  
     * @bodyParam  username string required The username field is required.' 
     * @response  401  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Forgot Password",
                                    "timestamp": "2022-01-13 08:58:49"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "User not available"
                                }
                            }
                        }
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Forgot Password",
                                    "timestamp": "2022-01-13 09:00:03"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The username field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "",
                                "timestamp": "2022-01-13 09:00:43"
                            },
                            "body": {
                                "status": true,
                                "msg": "OTP has been sent to your phone/email",
                                "data": {
                                    "otp_token": "eyJpdiI6IkJmWkFjWHJET1VQNWJEengzSmMydFE9PSIsInZhbHVlIjoiRnZ5Q0NmZCtEaHVoR1ZyTkZjVWRLa2FSRXBDd2lDN1RPZ0JrZU5jRGQxTT0iLCJtYWMiOiJkNGE5ODlmODcyNTk3MTJiZjIxYTk4MTNlN2E4NzljZDA4YjZiZGYxYWI4ODkzNTFjNThlMTdlMDVjOTU3ZGRkIn0="
                                }
                            }
                        }
                    }
     */

    public function forgot(Request $request)
    {
        $serviceName = 'Forgot Password';

        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ], [
            'username.required' => trans('app_auth_error.username.required'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $farmer = Farmer::with('country')
            ->orWhere('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$farmer) {
            return apiFormatResponse(trans('app_auth.user_not_found'), null, $serviceName, false, 401);
        }

        if (!$farmer->status) {
            return apiFormatResponse(trans('app_auth.account_unapproved'), null, $serviceName, false, 401);
        }

        $otp = random_int(100000, 999999);
        $string_token = Crypt::encryptString($farmer->id . '_' . $farmer->email . '_' . time());

        DB::table('password_resets')
            ->insert([
                'email' => $farmer->email,
                'token' => $string_token,
                'otp' => $otp,
                'generate_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]);

        try {
            Mail::to($farmer->email)->send(new \App\Mail\AppForgotPasswordEmail($farmer, $otp));
        } catch (\Exception $e) {
            Log::error($e);
        }

        try {
            $message = trans('app_auth.forgot_sms_text', ['name' => $farmer->name, 'app_name' => config('app.name'), 'otp' => $otp, 'mins' => config('common.otp_valid_min'), 'app_name' => config('app.name')]);

            $this->sendSMS($message, $farmer->phone);
        } catch (\Exception $e) {
            Log::error($e);
        }

        return apiFormatResponse(trans('app_auth.otp_sent'), ['otp_token' => $string_token]);
    }

    /**
     * OTP Match
     *  
     * @bodyParam  otp int,digits:6 required The otp field is required.' 
     * @bodyParam  forgot_token string required The forgot_token field is required.' 
     * @response  401  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Otp Match",
                                    "timestamp": "2022-01-13 09:07:05"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "Invalid Token"
                                }
                            }
                        }
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Otp Match",
                                    "timestamp": "2022-01-13 09:06:43"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The otp field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Otp Match",
                                "timestamp": "2022-01-13 09:09:05"
                            },
                            "body": {
                                "status": true,
                                "msg": "OTP has verified successfully",
                                "data": {
                                    "reset_token": "eyJpdiI6Ijk3KzlrU0FSQmVMdUVrY21UNlZ2dlE9PSIsInZhbHVlIjoiSGtZeHhuM0IzVGFwQjlpRDYrT2VCUDhOYTkwdWIwNWF3STZcL0l5MHFESFE9IiwibWFjIjoiYmZiOTI1ZWEwZmFiZmI5NjRmNTNiMmVjMzMzNTdmYjk4MzVkMzgzMTA5NWQwOWZiMGM2MzFmOGY5NDc1NDY3NSJ9"
                                }
                            }
                        }
                    }
     */


    public function otpMatch(Request $request)
    {
        $serviceName = 'Otp Match';

        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
            'forgot_token' => 'required',
        ], [
            'otp.required' => trans('app_auth_error.otp.required'),
            'otp.digits' => trans('app_auth_error.otp.digits'),
            'forgot_token.required' => trans('app_auth_error.forgot_token.required'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $password_reset = DB::table('password_resets')
            ->where('token', $request->forgot_token)
            ->first();

        if ($password_reset) {
            $totalDuration = Carbon::parse($password_reset->generate_at)
                ->diffInMinutes(Carbon::now());

            if ($totalDuration > config('common.otp_valid_min')) {
                return apiFormatResponse(trans('app_auth.otp_expire'), null, $serviceName, false, 400);
            }

            if ($password_reset->otp == $request->otp) {
                return apiFormatResponse(trans('app_auth.otp_verified'), ['reset_token' => $request->forgot_token], $serviceName);
            }

            return apiFormatResponse(trans('app_auth.invalid_otp'), null, $serviceName, false, 400);
        }

        return apiFormatResponse(trans('app_auth.invalid_token'), null, $serviceName, false, 401);
    }

    /**
     * Reset Password
     *  
     * @bodyParam  pin int,digits:6 required The pin field is required.
     * @bodyParam  confirm_pin int,digits:6,same:pin required The confirm_pin field is required. 
     * @bodyParam  reset_token string required The reset_token field is required. 
     * @response  401  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Reset Password",
                                    "timestamp": "2022-01-13 09:18:25"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "Invalid Token"
                                }
                            }
                        }
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Reset Password",
                                    "timestamp": "2022-01-13 09:18:53"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The pin field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Reset Password",
                                "timestamp": "2022-01-13 09:19:49"
                            },
                            "body": {
                                "status": true,
                                "msg": "Password reset successfully"
                            }
                        }
                    }
     */

    public function resetPassword(Request $request)
    {
        $serviceName = 'Reset Password';

        $validator = Validator::make($request->all(), [
            'reset_token' => 'required',
            'pin' => 'required|digits:6',
            'confirm_pin' => 'required|digits:6|same:pin',
        ], [
            'reset_token.required' => trans('app_auth_error.reset_token.required'),
            'pin.required' => trans('app_auth_error.pin.required'),
            'pin.digits' => trans('app_auth_error.pin.digits'),
            'confirm_pin.required' => trans('app_auth_error.confirm_pin.required'),
            'confirm_pin.same' => trans('app_auth_error.confirm_pin.same'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $password_reset = DB::table('password_resets')
            ->where('token', $request->reset_token)
            ->first();

        if ($password_reset) {
            $decrypted = explode('_', Crypt::decryptString($password_reset->token));
            $farmer = Farmer::with('country')->where(['id' => $decrypted[0]])->first();

            Farmer::where(['id' => $farmer->id])
                ->update(['is_suspend'=> 0, 'pin' => Hash::make($request->pin)]);

            DB::table('password_resets')->where(['email' => $decrypted[1]])->delete();

            return apiFormatResponse(trans('app_auth.reset_success'), null, $serviceName);
        }

        return apiFormatResponse(trans('app_auth.invalid_token'), null, $serviceName, false, 401);
    }

    /**
     * Resend OTP 
     *   
     * @bodyParam  forgot_token string required The forgot_token field is required.' 
     * @response  401  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Resend Otp",
                                    "timestamp": "2022-01-13 09:11:07"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "Invalid Token"
                                }
                            }
                        }
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Resend Otp",
                                    "timestamp": "2022-01-13 09:13:58"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The username field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "",
                                "timestamp": "2022-01-13 09:13:22"
                            },
                            "body": {
                                "status": true,
                                "msg": "OTP has been sent to your phone/email",
                                "data": {
                                    "otp_token": "eyJpdiI6IjdKcHIxeEQ0RlVYXC8xT05vWUF0ZmNRPT0iLCJ2YWx1ZSI6IjJ3WDJRelpcL1BNSlwvTld3eXE0UVhtTHFJYVwvSVo1Z1p0NHJvVEgwZmpVbE09IiwibWFjIjoiZDAyNGY2MTQ3OWYxNmM3ODY3YmRkZGYxYTYzYjBkMzVmYjk0MTJjYTNkNTgwZGM2MzEzNjljMmJmYTAxZTFhNCJ9"
                                }
                            }
                        }
                    }
     */

    public function resendOTP(Request $request)
    {
        $serviceName = 'Resend Otp';

        $validator = Validator::make($request->all(), [
            'forgot_token' => 'required',
        ], [
            'forgot_token.required' => trans('app_auth_error.username.required'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        $password_reset = DB::table('password_resets')
            ->whereToken($request->forgot_token)
            ->first();

        if ($password_reset) {
            $decrypted = explode('_', Crypt::decryptString($password_reset->token));
            $farmer = Farmer::with('country')->where(['id' => $decrypted[0]])->first();
            $otp = random_int(100000, 999999);

            DB::table('password_resets')
                ->where('token', $request->forgot_token)
                ->update([
                    'otp' => $otp,
                    'generate_at' => Carbon::now(),
                ]);

            try {
                Mail::to(trim($farmer->email))->send(new \App\Mail\AppForgotPasswordEmail($farmer, $otp));
            } catch (\Exception $e) {
                Log::error($e);
            }

            try {
                $message = trans('app_auth.forgot_sms_text', ['name' => $farmer->name, 'app_name' => config('app.name'), 'otp' => $otp, 'mins' => config('common.otp_valid_min'), 'app_name' => config('app.name')]);

                $this->sendSMS($message, $farmer->phone);
            } catch (\Exception $e) {
                Log::error($e);
            }

            return apiFormatResponse(trans('app_auth.otp_sent'), ['otp_token' => $request->forgot_token]);
        }

        return apiFormatResponse(trans('app_auth.invalid_token'), null, $serviceName, false, 401);
    }

    /**
     * Delete Farmer Account
     * 
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Delete Farmer Account",
                                "timestamp": "2022-01-13 09:26:26"
                            },
                            "body": {
                                "status": true,
                                "msg": "Your account deleted successfully"
                            }
                        }
                    }
     */

    public function deleteFarmer(Request $request)
    {
        $serviceName = 'Delete Farmer Account';
        $farmer_id = Auth::guard('api')->user()->id ;
        $country_id = auth()->guard('api')->user()->country_id ;
        $title = trans('app_notification.farmer_delete', ['farmer_name' => auth()->guard('api')->user()->name]);
        $device_type = getDeviceType(auth()->guard('api')->user()->id);

        Farmer::where('id', $farmer_id)->delete();
        FarmerDevice::where('farmer_id', $farmer_id)->delete();
        auth()->guard('api')->user()->token()->revoke();

        ////////////////// Sending Push Notification //////////////////
        $super_admin = getSuperAdminData();
        $res = $this->sendPushNotification(
            [
                'title' => $title,
                'item_id' => $farmer_id,
                'item_type' => config('common.notification_item_type.farmer_delete'),
                'country_id' => $country_id,
                'type' => 1,
                'device_type' => $device_type,
            ],
            [
                'user_id' => $super_admin['id'],
                'user_type' => $super_admin['role_id'],
            ],
            [$super_admin['fcm_token']],
            $super_admin['selected_country']['language'] ?? config('common.default_language'),
            $device_type
        );
        ////////////////// Sending Push Notification //////////////////

        return apiFormatResponse(trans('app_auth.user_delete'), null, $serviceName, true, 200);
    }


    /**
     * Get Schedule Delete Date
     * 
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Get Schedule Delete Date",
                                "timestamp": "2022-01-21 13:05:46"
                            },
                            "body": {
                                "status": true,
                                "msg": "",
                                "data": {
                                    "scheduled_deleted_date": "2020-03-01"
                                }
                            }
                        }
                    }
     */

    public function getScheduleDeletedDate(Request $request)
    {
        $serviceName = 'Get Schedule Delete Date';
        $scheduled_deleted_date =  Auth::guard('api')->user()->scheduled_deleted_date ;
        return apiFormatResponse('',['scheduled_deleted_date'=>$scheduled_deleted_date], $serviceName, true, 200);
    }


    /**
     * Schedule Delete Date
     *   
     * @bodyParam  scheduled_deleted_date string required The scheduled deleted date field is required.' 
     * @response  400  {
                            "APIService": {
                                "header": {
                                    "version": "v1",
                                    "serviceName": "Schedule Delete Date",
                                    "timestamp": "2022-01-21 13:10:42"
                                },
                                "body": {
                                    "status": false,
                                    "msg": "The scheduled deleted date  field is required."
                                }
                            }
                        }
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Schedule Delete Date",
                                "timestamp": "2022-01-21 13:14:52"
                            },
                            "body": {
                                "status": true,
                                "msg": "Schedule deleted data saved successfully"
                            }
                        }
                    }
     */

    public function scheduleDeletedDate(Request $request)
    {
        $serviceName = 'Schedule Delete Date';

        $validator = Validator::make($request->all(), [ 
            'scheduled_deleted_date' => 'required|date|date_format:Y-m-d', 
        ], [
            'scheduled_deleted_date.required' => trans('app_auth_error.scheduled_deleted_date.required'),
            'scheduled_deleted_date.date' => trans('app_auth_error.scheduled_deleted_date.date'),
            'scheduled_deleted_date.date_format' => trans('app_auth_error.scheduled_deleted_date.date_format'),
        ]);

        if ($validator->fails()) {
            return apiFormatResponse($validator->errors()->first(), null, $serviceName, false, 400);
        }

        Farmer::where('id', Auth::guard('api')->user()->id)->update(['scheduled_deleted_date'=>$request->scheduled_deleted_date]);

        return apiFormatResponse(trans('app_auth.scheduled_deleted_date_success'), null, $serviceName, true, 200);
    }

    /**
     * Logout
     * 
     * @response    {
                        "APIService": {
                            "header": {
                                "version": "v1",
                                "serviceName": "Logout",
                                "timestamp": "2022-01-13 09:23:19"
                            },
                            "body": {
                                "status": true,
                                "msg": "Logout sucessfully"
                            }
                        }
                    }
     */

    public function logout(Request $request)
    {
        $serviceName = 'Logout';
        FarmerDevice::where('farmer_id', Auth::guard('api')->user()->id)->delete();
        auth()->guard('api')->user()->token()->revoke();
        return apiFormatResponse(trans('app_auth.logout_success'), null, $serviceName, true, 200);
    }
}
