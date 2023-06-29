<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        try {

            // dd($request->email);
            $user = User::where('email', $request->email)->first();

            // $user = User::get();

            // dd($user);

            if (!$user) {
                return $this->errorResponse('invalid credentials', 401);
            }

            if (!Hash::check($request->password, $user->getAuthPassword())) {
                return $this->errorResponse('invalid credentialssss', 401);
            }

            $role = $user->role->role;


            $token = $user->createToken('bearer_token')->plainTextToken;

            $admin_id = Role::where('role', 'Admin')->first();

            $admin_id = $admin_id->user;

            $responseData = [
                'name' => $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->suffix,
                'role' => $role,
                'user_id' => $user->id,
                'admin_id' => $admin_id->id,
                'access_token' => $token,
                'token_type' => 'Bearer'


            ];


            return $this->successResponse($responseData,'User Logged in Successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
