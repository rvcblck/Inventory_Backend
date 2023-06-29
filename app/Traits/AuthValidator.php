<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait AuthValidator
{

    protected function validateCredentials($request, $type)
    {

        switch ($type) {
            case 'register':
                $validateUser = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required'
                ]);

                if ($validateUser->fails()) {
                    return $this->errorResponse($validateUser->errors(), 400);
                }
                break;

            case 'login':
                $validateUser = Validator::make(
                    $request->all(),
                    [
                        'email' => 'required|email',
                        'password' => 'required'
                    ]
                );

                if ($validateUser->fails()) {
                    return $this->errorResponse($validateUser->errors(), 401);

                }

                if (!Auth::attempt($request->only(['email', 'password']))) {
                    return $this->errorResponse('Email & Password does not match with our record.', 401);
                }
        }
    }
}
