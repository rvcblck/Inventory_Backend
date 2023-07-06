<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            foreach ($users as $user) {
                $user->profile_pic = $user->profile_pic ? asset('storage/profile_pic/' . $user->id . '/' . $user->profile_pic) : asset('storage/profile_pic/user-default.png/');
                $user->logo_url = $user->logo_url ? asset('storage/profile_pic/' . $user->id . '/' . $user->logo) : asset('storage/logo/logo.png/');
                $user->role = $user->role->role;
            }

            return $this->successResponse($users, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return $this->successResponse($user, 'Item created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->successResponse($user, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            return $this->successResponse(null, 'updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = User::findOrFail($id);

            $category->delete();

            return $this->successResponse(null, 'Item deleted successfully', 204);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function requestorCompanies()
    {

        try {
            // get role id of admin role
            $roleId = Role::where('role', 'Admin')->first();

            // get users with that admin role
            $users = $roleId->user;

            $companies = [];

            foreach ($users as $user) {
                // get data of thier companies each users
                $companies[] = $user->company;
            }

            foreach ($companies as $company) {

                $company->logo_url = $company->logo ? asset('storage/logo/' . $company->company_id . '/' . $company->logo) : asset('storage/logo/logo.png');
            }



            return $this->successResponse($companies, 'success', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
