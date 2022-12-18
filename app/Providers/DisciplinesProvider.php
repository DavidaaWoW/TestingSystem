<?php

namespace App\Providers;

use App\View\Composers\DisciplineComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class DisciplinesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('user.disciplines', DisciplineComposer::class);
    }
}
