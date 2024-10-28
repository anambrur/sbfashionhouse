<?php

namespace App\Providers;

use App\Http\Controllers\Admin\Common\Illuminate;
use App\Model\Common\Category;
use App\SM\SM;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Illuminate::bootServiceProvider();
        Schema::defaultStringLength(191);
        view()->share('categoriesWithSubcategories', Category::with('subcategories')->where('parent_id', 0)->get());

    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
