<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
   /**
    * Register any application services.
    */
   public function register(): void
   {
      //
   }

   /**
    * Bootstrap any application services.
    */
   public function boot(): void
   {
      View::composer('layout.app', function ($view) {
         $logo = Profile::first();
         $view->with('data', $logo);
      });

      View::composer('pages.auth.login', function ($view) {
         $logo = Profile::first();
         $view->with('data', $logo);
      });
   }
}
