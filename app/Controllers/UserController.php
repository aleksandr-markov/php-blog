<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    public function register()
    {
        return view('user/register');
    }

    public function store(): void
    {
        $model = new User();
        $model->loadData();

        if (!$model->validate()) {
            session()->setFlash('error', 'Validation errors');
            session()->set('formErrors', $model->getErrors());
            session()->set('formData', $model->attributes);
        } else {
            $model->attributes['password'] = password_hash($model->attributes['password'], PASSWORD_DEFAULT);

            if ($id = $model->save()) {
                session()->setFlash('success', 'Thanks for registration. Your ID: ' . $id);
            } else {
                session()->setFlash('error', 'Error registration');
            }

        }

        response()->redirect('/register');
    }

    public function login()
    {
        return view('user/login');
    }
}