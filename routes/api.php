<?php

use Illuminate\Support\Facades\Route;

//##### Postman Collection https://www.getpostman.com/collections/8382040b55371daa49fe ##### // 

Route::middleware('api_lang')->group(function () {
   Route::middleware(['auth:api', 'check_device_token','time_zone'])->group(function () {
      // get_user_details
      Route::post('update_profile', 'FarmerController@updateProfile');
      Route::post('change_password', 'FarmerController@changePassword');
      Route::get('get_user_details', 'FarmerController@getUserDetails');
      Route::get('get_user_country_list', 'FarmerController@getCountryUserList');
      Route::post('request_user_country', 'FarmerController@requestUserCountry');
      Route::post('set_user_country', 'FarmerController@setUserCountry');

      Route::get('getopt', 'FarmerController@getOption');
      Route::post('setopt', 'FarmerController@setOption');

      Route::post('get_bids', 'SellController@getBids');
      Route::post('bid_details', 'SellController@bidDetails');
      Route::post('bid_trading_history', 'SellController@bidTradingHistory');
      Route::post('bid_history_detail', 'SellController@bidTradingHistoryDetail');
      Route::get('sells_master', 'SellController@sellsMaster');
      Route::post('sells_request', 'SellController@sellsRequest');
      Route::post('accept_reject_bid', 'SellController@acceptRejectBid');

      Route::post('commodity_list', 'MarketController@commodityList');

      Route::post('notification', 'NotificationController@getNotification');
      Route::post('sendnotification', 'NotificationController@sendNotification');
      Route::post('seennotification', 'NotificationController@seenNotification');
      Route::get('notificationcount', 'NotificationController@notificationCount');

      Route::get('delete_farmer', 'AuthController@deleteFarmer');
      Route::get('get_schedule_deleted_date', 'AuthController@getScheduleDeletedDate');
      Route::post('schedule_deleted_date', 'AuthController@scheduleDeletedDate');

      Route::get('logout', 'AuthController@logout');
   });

   Route::middleware('time_zone')->group(function () {
      // new Routes
      Route::post('login', 'AuthController@login');
      Route::post('signup', 'AuthController@signup');
      Route::post('forgot', 'AuthController@forgot');
      Route::post('otp_match', 'AuthController@otpMatch');
      Route::post('resend_otp', 'AuthController@resendOTP');
      Route::post('reset_password', 'AuthController@resetPassword');

      Route::post('get_news', 'NewsController@getNewsList');
      Route::post('get_faq_list', 'FAQController@getFAQList');
      Route::post('news_details', 'NewsController@newsDetails');
      Route::post('marketing', 'MarketingController@marketingList');
      Route::post('marketing_details', 'MarketingController@marketingDetails');
      Route::post('get_static_contents', 'StaticContentController@getStaticContents');
      
   });


      Route::get('master', 'MasterController@getMasterData');

});
