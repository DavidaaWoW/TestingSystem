<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

class DisciplineComposer
{

    public function __construct()
    {
    }

    public function compose(ViewView $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $view->with('user_disciplines', $user->disciplines);
        }
    }
}
