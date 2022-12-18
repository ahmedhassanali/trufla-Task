<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;

class AuthController extends Controller
{

    use ApiResponser;

    public function login(UserLoginRequest $request)
    {
        $cred = $request->only('user_name', 'password');
        $token = Auth::attempt($cred);

        if (!$token)
            return $this->errorResponse('Unauthorized', 401);

        $user = Auth::user();
        $user['token'] = $token;
        return $this->successResponse($user, 'user logged in');
    }


    public function logout()
    {
        try {
            Auth::logout();
            return  $this->successResponse(null, message: 'Successfully logged out');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    
}
