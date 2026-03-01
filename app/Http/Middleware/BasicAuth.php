<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAuth
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->getUser();
        $pass = $request->getPassword();

        $adminUser = env('ADMIN_USER');
        $adminPass = env('ADMIN_PASS');

        if ($user !== $adminUser || $pass !== $adminPass) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic',
            ]);
        }

        return $next($request);
    }
}
