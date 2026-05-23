<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;
use Src\View;

class BearerAuthMiddleware
{
    public function handle(Request $request): Request
    {
        $token = Auth::bearerTokenFromRequest($request);

        if (!Auth::authenticateByBearer($token)) {
            (new View())->toJSON(['error' => 'Требуется авторизация'], 401);
        }

        return $request;
    }
}
