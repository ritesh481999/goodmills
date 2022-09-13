<?php

use App\Mail\SendAccAcceptOrRejectEmail;
use Illuminate\Support\Facades\Mail;

use App\Utils\File;
use App\Utils\Error;
use App\Utils\ApiResponseBuilder;

use App\Models\User;
use App\Models\Notification;
use App\Models\CountryMaster;
use App\Models\Farmer;
use App\Models\News;
use App\Models\Marketing;
use App\Models\Bid;
use App\Models\FarmerDevice;
use App\Models\NotificationUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Integer;

function remainingTime($end_date_time)
{
    $curr_date_time = Carbon::now();
    $interval = $curr_date_time->diff($end_date_time);

    if ($curr_date_time > $end_date_time) {
        return 0;
    }

    $year = $interval->format('%y');
    $year_text = ($year > 1) ? 'Years' : 'Year';
    $month = $interval->format('%m');
    $month_text = ($month > 1) ? 'Months' : 'Month';
    $day = $interval->format('%d');
    $day_text = ($day > 1) ? 'Days' : 'Day';
    $hour = $interval->format('%h');
    $hour_text = ($hour > 1) ? 'Hrs' : 'Hr';
    $minute = $interval->format('%i');
    $minute_text = ($minute > 1) ? 'Mins' : 'Min';

    $remaining_time = '';

    if ($year) {
        $remaining_time .= " $year $year_text";
    }

    if ($month) {
        $remaining_time .= " $month $month_text";
    }

    if ($day) {
        $remaining_time .= " $day $day_text";
    }

    if ($hour) {
        $remaining_time .= " $hour $hour_text";
    }

    if ($minute) {
        $remaining_time .= " $minute $minute_text";
    }

    return trim($remaining_time);
}

function fileUpload(\Illuminate\Http\UploadedFile $file, string $dir, string $fileNamePrefix = '', $disk = null): string
{
    return File::make($dir, $disk)->upload($file, $fileNamePrefix);
}

function removeFile(string $path, $disk = null): bool
{
    return File::make($path, $disk)->destroy($path);
}

function fileUrl(string $path, int $expiresIn = 60, string $disk = null): string
{
    return File::make($path, $disk)->url($expiresIn);
}

function displayDate(string $dt, $format = 'd-M-Y'): string
{
    return \Carbon\Carbon::parse($dt)->format($format);
}

function displayDateTime(string $dt): string
{
    return \Carbon\Carbon::parse($dt)->format('d-M-Y h:i A');
}

function filterDate(string $dt): string
{
    return \Carbon\Carbon::parse($dt)->format('Y-m-d');
}

function displayMonthYear(string $dt): string
{
    return \Carbon\Carbon::parse($dt)->format('F Y');
}


function apiFormatResponse(string $message, array $data = null, string $serviceName = null, bool $status = true, int $httpStatus = 200)
{
    if ($serviceName !== null)
        ApiResponseBuilder::setServiceName($serviceName);

    return ApiResponseBuilder::make(
        $message,
        $data,
        $status,
        $httpStatus
    )
        ->get();
}

// for pagination response
function paginationResponse($data, string $message, string $serviceName = null, bool $status = true, int $httpStatus = 200, array $arr_data = [], array $append_array_data = [])
{
    $body = [
        'total' => $data->count(),
        'total_count' => $data->total(),
        'current_page' => $data->currentPage(),
        'last_page' => $data->lastPage()
    ];
    if (count($append_array_data)) {
        $body = array_merge($body, $append_array_data);
    }

    if ($serviceName)
        ApiResponseBuilder::setServiceName($serviceName);

    return ApiResponseBuilder::make(
        $message,
        count($arr_data) ? $arr_data : $data->items(),
        $status,
        $httpStatus
    )
        ->addBody($body)
        ->get();
}

function apiPaginationResponse($model, int $page = 1, string $message, string $serviceName = null, array $columns = ['*'], $mapItemCB = null)
{
    if (false === ($model instanceof \Illuminate\Database\Eloquent\Builder || $model instanceof \Illuminate\Database\Query\Builder))
        throw new \Exception('$model is invalid, it must be either instance of Illuminate\Database\Eloquent\Builder or Illuminate\Database\Query\Builder', 1);

    $m = $model->paginate(config('common.api_max_result_set'), $columns, 'page', $page);

    if ($serviceName !== null)
        ApiResponseBuilder::setServiceName($serviceName);

    if ($page > $m->lastPage())
        Error::error('Page is number is out of scope');

    $body = [
        'total' => $m->total(),
        'per_page' => $m->count(),
        'current_page' => $m->currentPage(),
        'last_page' => $m->lastPage()
    ];

    if ($mapItemCB)
        $data = $mapItemCB($m->items());
    else
        $data = $m->items();

    $builder = ApiResponseBuilder::make(
        $message,
        $data
    );

    return $builder->addBody($body)->get();
}

function getTonnages(string $order = 'desc')
{
    $tonnages = config('common.tonnage');
    if (strtolower($order) == 'asc')
        asort($tonnages);
    elseif (strtolower($order) == 'desc')
        rsort($tonnages);
    return $tonnages;
}

function hasCountryCode(string $number, string $countryCode = null)
{
    if (empty($countryCode))
        $countryCode = config('common.country_code');
    return starts_with($number, $countryCode) || starts_with($number, '+');
}

function withCountryCode(string $number, string $countryCode = null)
{
    if (empty($countryCode))
        $countryCode = config('common.country_code');
    if (hasCountryCode($number, $countryCode))
        return $number;
    return $countryCode . $number;
}

function get_language_code_by_country_id($country_id)
{
    $language_code = '';
    $countryData   = CountryMaster::where(['id' => $country_id])->first();
    $language_code =  $countryData ? strtolower($countryData->language) : config('common.default_language');

    return $language_code;
}

function pagination_response($model, int $per_page = 10, int $page = 1, string $message, string $serviceName = null, bool $status = true, array $columns = ['*'], $mapItemCB = null)
{
    if (false === ($model instanceof \Illuminate\Database\Eloquent\Builder || $model instanceof \Illuminate\Database\Query\Builder))
        throw new \Exception('$model is invalid, it must be either instance of Illuminate\Database\Eloquent\Builder or Illuminate\Database\Query\Builder', 1);

    $m = $model->paginate($per_page);

    if ($serviceName !== null)
        ApiResponseBuilder::setServiceName($serviceName);

    if ($page > $m->lastPage())
        Error::error('Page is number is out of scope');

    $body = [
        'status' => $status,
        'total' => $m->total(),
        'per_page' => $per_page,
        'current_page' => $m->currentPage(),
        'last_page' => $m->lastPage()
    ];

    if ($mapItemCB)
        $data = $mapItemCB($m->items());
    else
        $data = $m->items();

    $builder = ApiResponseBuilder::make(
        $message,
        $data
    );

    return $builder->addBody($body)->get();
}


// function sendEmail($emails, $subject, $template, $data = NULL)
// {
//     if (!count($emails)) {
//         return false;
//     }

//     Mail::send([], [], function ($message) use ($emails, $subject, $template, $data) {
//         foreach ($emails as $email) {
//             $message->to($email);
//         }

//         $message->subject($subject)->setBody($template, 'text/html');

//         if ('' != $data) {
//             $message->attachData($data);
//         }
//     });

//     if (count(Mail::failures()) > 0) {
//         return false;
//     } else {
//         return true;
//     }
// }

function countries()
{
    $countries = CountryMaster::where('status', 1)->get();
    return $countries;
}

function getMonthOfMovement()
{
    $month_movement = [];
    $current_date = date('d');
    $current_month = date('m');
    $current_year = date('Y');
    $end_date = date('d', strtotime('3 years'));
    $end_month = date('m', strtotime('3 years'));
    $end_year = date('Y', strtotime('3 years'));

    for ($year = $current_year; $year <= $end_year; $year++) {
        $month = 1;
        $max_month = 12;

        if ($year == $end_year)
            $max_month = (int) $current_month;

        if ($year == $current_year)
            $month = (int) $current_month;

        for ($month; $month <= $max_month; $month++) {

            $month_lable = in_array($month, ['1', '2', '3', '4', '5', '6', '7', '8', '9']) ? '0' . $month : $month;
            $currect_end_date = '';

            if (in_array($month, ['1', '3', '5', '7', '8', '10', '12'])) {
                $currect_end_date = $current_date == $end_date && $current_month == $end_month && $current_year == $end_year ? $current_date :  '31';
            } else  if (in_array($month, ['2'])) {
                if ($current_date == $end_date && $current_month == $end_month && $current_year == $end_year) {
                    $currect_end_date = $current_date;
                } else {
                    if ($year % 400 == 0 || $year % 4 == 0) {
                        $currect_end_date = '29';
                    } else {
                        $currect_end_date = '28';
                    }
                }
            } else if (in_array($month, ['4', '6', '9', '11'])) {
                $currect_end_date = $current_date == $end_date && $current_month == $end_month && $current_year == $end_year ? $current_date :  '30';
            }


            $new_date   = "{$year}-{$month_lable}-{$end_date}";
            $month_name = in_array($month, ['1', '2', '3', '4', '5', '6', '7', '8', '9']) ? '0' . $month : $month;
            $month_movement[] = [
                //'date' => $year . '-' . $month_lable . '-' . $end_date,
                'date' => $year . '-' . $month_lable . '-' . $currect_end_date,
                // 'month' => date("M", strtotime($month)) . ' ' . $year,
                'month' => date('M', strtotime($year . '-' . $month_lable . '-' . $currect_end_date)),
            ];
        }
    }

    return $month_movement;
}

function multipleFileUpload(\Illuminate\Http\UploadedFile $file, string $dir, string $fileNamePrefix = '', $disk = null): string
{
    return File::make($dir, $disk)->upload($file, $fileNamePrefix);
}


function multipleFilesRemove(object $files, $disk = null): bool
{
    foreach ($files as $path) {
        File::make($path->file_name, $disk)->destroy($path);
    }

    return true;
}


function generateUniqueBidCode()
{
    return  'GMG-' . rand(1000, 9999) . date("Hi");
}

function static_content_type($value = null)
{
    $content_type  = [
        '0' => [
            'name' => trans('common.static_contents.pages.faqs'),
            'slug' => 'faqs'
        ],
        '1' =>  [
            'name' => trans('common.static_contents.pages.terms_and_conditions'),
            'slug' => 'terms-and-conditions'
        ],
        '2' => [
            'name' => trans('common.static_contents.pages.privacy_policy'),
            'slug' => 'privacy-policy'
        ],
        '3' => [
            'name' => trans('common.static_contents.pages.help'),
            'slug' => 'help'
        ]
    ];

    return $value ? $content_type[$value]['name'] : $content_type;
}



function getAllMonthsWithYear()
{
    $yms = array();
    $now = date('Y-m');
    for ($x = 12; $x >= 1; $x--) {
        $ym = date('Y-m', strtotime($now . " -$x month"));
        $month_name = date("F", strtotime($now . " -$x month" . "-1"));
        $yms[$ym] = $month_name;
    }


    return $yms;
}
// function notificationItemTypeData($data,$item_type){

// }

function sendNotification(object $notification,  $user_data, array $fcm_token, $notification_count, string $language_code = 'en', $device_type = 2)
{
    // $notification_title = "";
    // App::setLocale($language_code);

    // $SERVER_API_KEY     = config('common.fcm_server_key');
    // $notification_body  = $notification_data['description'] ?? '';

    // $title              = $notification_data['title'] ?? 'New notification';

    // $notification_data['type']  = $notification_data['type'] ?? 1; // 1-web notification / 2 - push notification
    // $notification_data['device_type']  = $notification_data['device_type'] ?? 1; // 1-web / 2 - android / 3- ios
    // $notification_data['ip_address'] =  $notification_data['ip_address'] ??  \Request::ip();
    // // dd($notification_data);
    // if (isset($notification_data['item_type'])) {

    //     if ($notification_data['item_type'] == 1) {
    //         $notification_title = trans('app_notification.news_title', ['title' => $title]);
    //     } else if ($notification_data['item_type'] == 2) {
    //         $notification_title = trans('app_notification.marketing_title', ['title' => $title]);
    //     } else if ($notification_data['item_type'] == 3) {
    //         $notification_title = trans('app_notification.bids_title', ['title' => $title]);
    //     } else if ($notification_data['item_type'] == 4) {
    //         $notification_title = trans('app_notification.selling_request_title', ['title' => $title]);
    //     } else {
    //         $notification_title = $title;
    //     }
    // } else {
    //     throw new \Exception('Pass to item_type params in $notification_data variable', 1);
    // }

    $data = [
        "registration_ids" => $fcm_token,
        // "notification" => [
        //     'message'     => $notification_body,
        //     'title'        => $notification_title,
        //     'subtitle'    => '',
        //     'vibrate'    => 1,
        //     'sound'        => 1,
        //     'largeIcon'    => 'large_icon',
        //     'smallIcon'    => 'small_icon',
        //     'item_id' => $notification_data['item_id'],
        //     'item_type' => $notification_data['item_type'],
        //     'icon'	=> env('APP_URL') ."/public/assets/media/logos/favicon.png"
        // ],
        // "data" => [
        //     'message'     => $notification_body,
        //     'title'        => $notification_title,
        //     'subtitle'    => '',
        //     'vibrate'    => 1,
        //     'sound'        => 1,
        //     'largeIcon'    => 'large_icon',
        //     'smallIcon'    => 'small_icon',
        //     'item_id' => $notification_data['item_id'],
        //     'item_type' => $notification_data['item_type']
        // ]
    ];

    if ($device_type ==  2) {  /// IOS 
        $data['notification'] =  [
            'message'     => $notification->description,
            'title'        => $notification->title,
            'subtitle'    => '',
            'vibrate'    => 1,
            'sound'        => 1,
            'largeIcon'    => 'large_icon',
            'smallIcon'    => 'small_icon',
            'item_id' => $notification->item_id,
            'item_type' => $notification->item_type,
            'icon'    => env('APP_URL') . "/public/assets/media/logos/favicon.png"
        ];
    } else if ($device_type ==  1) {  /// Android
        $data['data'] =  [
            'message'     => $notification->description,
            'title'        => $notification->title,
            'subtitle'    => '',
            'vibrate'    => 1,
            'sound'        => 1,
            'badge'   => $notification_count +  1,
            'largeIcon'    => 'large_icon',
            'smallIcon'    => 'small_icon',
            'badge' => notificationCount(),
            'item_id' => $notification->item_id,
            'item_type' => $notification->item_type
        ];
    }

    $dataString = json_encode($data);
    $headers = [
        'Authorization: key=' . config('common.fcm_server_key'),
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    $firebase_response = curl_exec($ch);
    $notification_data['firebase_response'] = $firebase_response;
   // $notification = Notification::create($notification_data);
    // $user_data = array_map(function ($arr) use ($notification) {
    //     return $arr + [
    //         'notification_id' => $notification->id,'firebase_response' =>   $notification_data['firebase_response'] ,'created_at' => date('Y-m-d H:i:s'),
    //         'updated_at' => date('Y-m-d H:i:s')
    //     ];
    // }, $user_data);
    $user_data = [
        'user_id' => $user_data->id,
        'notification_id' => $notification->id,
        'firebase_response' => $firebase_response,
        'user_type' => $user_data->user_type,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')

    ];
    NotificationUser::insert($user_data);
    return $firebase_response;
}



function selling_request_status($value = null)
{
    $status  = [
        "1" => trans('common.selling_request.status.request_received'),
        "2" => trans('common.selling_request.status.bid_sent'),
        "3" => trans('common.selling_request.status.request_rejected_by_admin'),
        "4" => trans('common.selling_request.status.bid_accepted_by_farmer'),
        "5" => trans('common.selling_request.status.bid_reject_by_farmer'),
        "6" => trans('common.selling_request.status.counter_offer_accepted_by_admin'),
        "7" => trans('common.selling_request.status.counter_offer_rejected_by_admin'),
    ];

    return $value ? $status[$value] : $status;
}

function getSuperAdminData()
{
    $data = User::with('selected_country')
        ->where(['role_id' => config('common.user_role.SUPERADMIN')])
        ->first();
    return $data ? $data->toArray() : $data;
}


function getAllNotification()
{
    $user = Auth::user();
    $notifications = Notification::query();
    if (auth()->user()->is_super_admin) {
        $notifications =  $notifications->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
            $q->where('user_type', 1);
            $q->where('is_seen', 0);
        });
    } else {
        $notifications = $notifications->whereHas('users', function ($q) {
            $q->where('user_type', 1);
            $q->where('is_seen', 0);
        })->where('country_id',$user->selected_country_id);
    }
    $notifications = $notifications->select(['id', 'item_type', 'item_id', 'title', 'created_at'])->with('users')->limit(5)->orderBy('id', 'desc')->get();

    return $notifications;
}

function notificationCount()
{
    $user = Auth::user();
    $notification_count = Notification::query();
    if (auth()->user()->is_super_admin) {
        $notification_count =  $notification_count->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
            $q->where('user_type', 1);
            $q->where('is_seen', 0);
        });
    } else {
        $notification_count = $notification_count->whereHas('users', function ($q)  {
            $q->where('user_type', 1);
            $q->where('is_seen', 0);
        })->where('country_id',$user->selected_country_id);
    }
    $notification_count = $notification_count->count();
    return $notification_count;
}

function getItemTypeUrl($item_type)
{

    $item = config('common.notification_item_type');

    switch ($item_type) {
        case $item['selling_request']:
            return 'selling_request';
            break;
        case $item['bid_accecpt_by_farmer']:
            return 'bid';
            break;
        case $item['bid_reject_by_farmer']:
            return 'bid';
            break;
        case $item['country_request_by_farmer']:
            return 'farmer';
        case $item['farmer_delete']:
            return 'deleted_accounts';
            break;
    }
}

function updateNotificationStatus($notification_id)
{

    $notification = Notification::find($notification_id);
    $notification = $notification->user();
    if (auth()->user()->is_super_admin) {
        $notification->where('user_id', auth()->user()->id)->where('user_type', 1);
    }
    else
    {
        $notification->where('user_id', auth()->user()->selected_country_id)->where('user_type', 1);
    }
    $notification->update(['is_seen' => 1]);
    return $notification ? true : false;
}

function sendEmail($farmer)
{

    if ($farmer->is_suspend == true) {
        $subject = __('common.email.account_suspended_subject');
        $body = __('common.email.hi_greet', ['name' => $farmer->name]) . '<br>' . __('common.email.account_suspended_body');
        Mail::to($farmer->email)->send(new SendAccAcceptOrRejectEmail($farmer, $body, $subject));
    } elseif ($farmer->status == true && $farmer->last_login_at == NULL) {
        $subject = __('common.email.account_approval_subject');
        $body = __('common.email.hi_greet', ['name' => $farmer->name]) . '<br>' . __('common.email.account_approval_body');
        Mail::to($farmer->email)->send(new SendAccAcceptOrRejectEmail($farmer, $body, $subject));
    } elseif ($farmer->status == false) {
        $subject = __('common.email.account_rejection_subject');
        $body = __('common.email.hi_greet', ['name' => $farmer->name]) . '<br>' . __('common.email.account_rejection_body') . $farmer->reason;
        Mail::to($farmer->email)->send(new SendAccAcceptOrRejectEmail($farmer, $body, $subject));
    }
}

function superAdminEmail()
{
    $emailId = User::with('selected_country')->select(['email'])
        ->where(['role_id' => config('common.user_role.SUPERADMIN')])
        ->first();
    //return $emailId->email ;
    return 'amresh@webol.co.uk';
}

function getDeviceType($user_id)
{
    $farmer_device = FarmerDevice::where('farmer_id',$user_id)->first();
    return $farmer_device->device_type;
}

function isNotificationDelete($item_id,$item_type)
{
    $is_deleted = 0 ; 

    if($item_type == config('common.notification_item_type.news')) {
        return News::onlyTrashed()->find($item_id) ?  1 : 0 ; 
    }
    if($item_type == config('common.notification_item_type.marketing')) {
        return Marketing::onlyTrashed()->find($item_id) ?  1 : 0 ; 
    }
    if($item_type == config('common.notification_item_type.bids')) {
        return Bid::onlyTrashed()->find($item_id) ? 1 : 0 ; 
    }

    return $is_deleted ;
    
}
