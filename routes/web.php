<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('config:cache');
	Artisan::call('view:clear');

	return "Cleared!";
});

Route::get('/', function () {
	// temproray redirection
	return redirect()->route('auth.login');
});




Route::get('file/{file_path}', 'Controller@getFileFromUrl')->name('getFileFromUrl');

Route::name('auth.')->prefix('auth')->namespace('Auth')->group(function () {
	Route::get('login', 'LoginController@showLoginForm')->name('login');
	Route::post('login', 'LoginController@login')->name('login');
	Route::get('logout', 'LoginController@logout')->name('logout');
	Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password');
	Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password');
	Route::post('otp-verify', 'ForgotPasswordController@verifyOtp')->name('forget.password.otp.verify');
	Route::get('reset-password', 'ResetPasswordController@showResetPasswordForm')->name('reset.password');
	Route::post('reset-password', 'ResetPasswordController@submitResetPasswordForm')->name('reset.password');
});

Route::group(["namespace" => "Web", 'middleware' => ['auth', 'lang']], function () {
	Route::get('/dashboard',  ['uses' => 'DashboardController@index', 'as' => 'dashboard']);
	Route::post('/storeToken',  ['uses' => 'DashboardController@storeToken', 'as' => 'storeToken']);

	Route::get('/masters',  ['uses' => 'MasterController@index', 'as' => 'masters']);
	Route::prefix('admin')->name('admin.')->group(function () {
		Route::get('', 'AdminController@index')->name('index');
		Route::get('create', 'AdminController@create')->name('create');
		Route::post('', 'AdminController@store')->name('store');
		Route::get('edit/{id}', 'AdminController@edit')->name('edit');
		Route::patch('{id}', 'AdminController@update')->name('update');
		Route::delete('delete/{id}', 'AdminController@delete')->name('delete');
		Route::get('change/password', 'AdminController@changePassword')->name('change.password');
		Route::post('change/password', 'AdminController@updateChangePassword')->name('change.password.update');
		Route::get('lang/change', 'AdminController@changeLanguage')->name('changeLang');
	});

	Route::resource('delivery_location', 'DeliveryLocationController');
	Route::resource('variety', 'VarietyController');
	Route::resource('specification', 'SpecificationMasterController')->except(['show']);
	Route::resource('country', 'CountryMasterController');
	Route::resource('marketing', 'MarketingController');
	Route::resource('farmer', 'FarmerController');
	Route::get('farmer/country/{id}','FarmerController@viewFarmerCountries')->name('farmer.countries');
	Route::post('farmer/country','FarmerController@updateFarmerCountry')->name('farmer.countries');
	Route::resource('news', 'NewsController')->except(['show']);
	Route::resource('commodity', 'CommodityMasterController')->except(['show']);
	Route::post('farmer_status', 'FarmerController@farmerStatus')->name('farmers.status');
	Route::resource('farmer_group', 'FarmerGroupController')->except(['show', 'delete']);
	Route::resource('selling_request', 'SellingRequestController');
	Route::post('selling_request/reject', 'SellingRequestController@reject')->name('selling_request.reject');
	Route::resource('bid_location','BidLocationMasterController')->except(['show']);
	Route::resource('bid', 'BidController');
	Route::post('bid/accept', 'BidController@accept_counter_offer')->name('bid.accept');
	Route::post('bid/reject', 'BidController@reject_counter_offer')->name('bid.reject');
	Route::get('bid/get_data/{id}',  ['uses' => 'BidController@get_data', 'as' => 'getData']);
	Route::patch('bid/update_status/{id}', 'BidController@updateStatus')->name('bid.update_status');
	Route::resource('static_contents', 'StaticContentController');
	Route::post('static_contents/faqs/store', 'StaticContentController@storeFaqs')->name('static_content.faqs.store');
	Route::post('deeditor/image_upload', 'CkeditorController@uploadImages')->name('ckEditorupload');
	Route::resource('deleted_accounts','DeletedAccountController');
	Route::get('restore_deleted_account/{id}','DeletedAccountController@restore')->name('deleted_account.restore');
	Route::resource('notifications','NotificationController');
});
