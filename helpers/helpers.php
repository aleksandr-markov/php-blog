<?php

use JetBrains\PhpStorm\NoReturn;
use PHPFramework\Application;
use PHPFramework\Database;
use PHPFramework\Request;
use PHPFramework\Response;
use PHPFramework\Session;
use PHPFramework\View;


function app(): Application
{
    return Application::$app;
}

function request(): Request
{
    return app()->request;
}

function response(): Response
{
    return app()->response;
}

function session(): Session
{
    return app()->session;
}

function db(): Database
{
    return app()->db;
}


function checkAuth(): bool
{
    return false;
}

function view(string $view = '', array $data = [], string|bool $layout = ''): string|View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }

    return app()->view;
}

#[NoReturn]
function abort(string $error = '', int $code = 404): void
{
    response()->setResponseCode($code);
    echo view("errors/{$code}", ['error' => $error], false);

    die;
}

function baseUrl($path = ''): string
{
    return PATH . $path;
}

function getAlerts(): void
{
    if (!empty($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $key => $value) {
            $ucfirstKey = ucfirst($key);

            echo \view()->renderPartial("partials/alert_{$key}", [
                "flash{$ucfirstKey}" => \session()->getFlash($key)
            ]);
        }
    }
}

function getErrors(string $fieldName): string
{
    $output = '';
    $errors = session()->get('formErrors');
    if (isset($errors[$fieldName])) {
        $output .= '<div class="invalid-feedback d-block"><ul class="list-unstyled">';
        foreach ($errors[$fieldName] as $error) {
            $output .= "<li>$error</li>";
        }
        $output .= '</ul></div>';
    }
    return $output;
}

function getValidationClass($fieldName): string
{
    $errors = session()->get('formErrors');
    if (empty($errors)) {
        return '';
    }

    return isset($errors[$fieldName]) ? 'is-invalid' : 'is-valid';
}

function old(string $fieldName): string
{
    return isset(session()->get('formData')[$fieldName]) ? h(session()->get('formData')[$fieldName]) : '';
}

function h(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function getCsrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . session()->get('csrf_token') . '">';
}