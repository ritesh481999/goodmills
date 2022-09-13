<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Farmer;
use App\Models\FarmerDevice;

class CheckDeviceToken
{

    public function handle($request, \Closure $next)
    {  
        $farmer_device = FarmerDevice::where('farmer_id', Auth::guard('api')->user()->id)->first();

        $device_token = $request->header('device-token') ?? '';
        if ($device_token && $farmer_device && isset($farmer_device->device_token) && $farmer_device->device_token == $device_token) {
            return $next($request);
        }
        return apiFormatResponse(trans('Your token expired please login'), null, '', false, 401);
    }
}
