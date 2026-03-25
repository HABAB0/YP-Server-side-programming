<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
            exit;
        }
        $user = Auth::user();
        if ($user['role_id'] !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }
    }
}