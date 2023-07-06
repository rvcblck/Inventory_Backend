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


            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->errorResponse('invalid credentials', 401);
            }

            if (!Hash::check($request->password, $user->getAuthPassword())) {
                return $this->errorResponse('invalid credentialssss', 401);
            }

            $role = $user->role->role; // admin, requestor, supplier etc.

            $token = $user->createToken('bearer_token')->plainTextToken;

            $companyInfo = $user->company;

            $isRoleAdminId = Role::where('role', 'Admin')->first();

            $admin_id = User::where('role_id', $isRoleAdminId->role_id)
                ->where('company_id', $companyInfo->company_id)
                ->first();






            // dd($companyInfo->company_id);






            $responseData = [
                'name' => $user->fname . ' ' . $user->mname . ' ' . $user->lname . ' ' . $user->suffix,
                'role' => $role,
                'user_id' => $user->id,
                'admin_id' => $admin_id->id,
                'companyInfo' => $companyInfo,
                'access_token' => $token,
                'token_type' => 'Bearer'


            ];


            return $this->successResponse($responseData, 'User Logged in Successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
