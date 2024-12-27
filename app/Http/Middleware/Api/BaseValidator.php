<?php

namespace App\Http\Middleware\Api;

use Illuminate\Support\Facades\Validator;

class BaseValidator
{
    public function authValidator ($request)
    {
        if ($request->route()->name('register')) {
            return Validator::make($request->all(), [
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8|confirmed',
            ]);
        } else if ($request->route()->name('login')) {
            return Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required|min:8',
            ]);
        }
    }

    public function recordValidator ($request)
    {
        return Validator::make($request->all(), [
            "name" => "required",
            "image" => "required|url",
            "category_id" => "required"
        ]);
    }

    public function userValidator ($request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);
    }
}
