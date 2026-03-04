<?php

namespace PHPFramework;

class Response
{
    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $url = '')
    {
        if ($url) {
            $redirect = $url;
        } else {
            $redirect = $_SERVER['HTTP_REFERER'] ?? baseUrl('/');
        }

        header("Location: {$redirect}");
        exit();
    }
}