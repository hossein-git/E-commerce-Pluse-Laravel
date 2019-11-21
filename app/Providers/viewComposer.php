<?php

namespace App\Providers;

use adminComposer;
use App\view\composer\frontComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class viewComposer extends ServiceProvider
{

    public function adminComposer()
    {
        \view()->composer('admin.products.index',\App\view\composer\adminComposer::class);
        \view()->composer('admin.*','\App\view\composer\adminComposer@menuCount');
    }

    public function frontComposer()
    {
        \view()->composer(['layout.front.*','Front.*'],frontComposer::class);
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->adminComposer();
        $this->frontComposer();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
