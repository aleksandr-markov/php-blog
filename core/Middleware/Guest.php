<?php

namespace PHPFramework\Middleware;

class Guest
{

    public function handle(): void
    {

        if (checkAuth()) {
            response()->redirect(baseUrl('/dashboard'));
        }
    }

}