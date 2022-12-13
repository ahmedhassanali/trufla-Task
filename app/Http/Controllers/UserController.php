<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponser;

class UserController extends Controller
{
    use ApiResponser;

    public function __construct(private UserService $userService)
    {
        
    }
    public function index()
    {
        try {
            $users = $this->userService->getAll();
            return $this->successResponse($users,'All Users');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $user=$this->userService->store($request->all());
            return $this->successResponse($user,'User_saved_successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $user=$this->userService->update($request->all() ,$user->id);
            return $this->successResponse($user,'User_updated_successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function show(User $user)
    {
        try {
            $user = $this->userService->find($user->id);
            return $this->successResponse($user,'success');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->delete($user->id);
            return $this->successResponse("success",'User_deleted_successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
