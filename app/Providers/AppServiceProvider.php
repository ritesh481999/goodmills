<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use App\Models\User;
use App\Models\CountryMaster;
use App\Providers\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
            }
    }

    public function boot()
    {
        view()->composer(
            'partials.header',
            function ($view) {
                $user = User::findOrFail(auth()->user()->id);

                if ($user->is_super_admin) {
                    $countryData = CountryMaster::where('status', 1)->get();
                } else {
                    $countryData = $user->countries()->get();
                }

                $view->with('countryData', $countryData);
            }
        );

        Schema::defaultStringLength(191);
    }
}
