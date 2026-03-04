<?php

namespace PHPFramework\Middleware;

class Auth
{

    public function handle(): void
    {

        if (!checkAuth()) {
            session()->setFlash('error', 'Forbidden');
            response()->redirect(baseUrl('/login'));
        }
    }

}