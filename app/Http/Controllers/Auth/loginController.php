<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Lib\AuthenticatorFacade as Authenticator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function login(Request $request): JsonResponse
    {
        $auth = Authenticator::init($request);
        $auth->validate([
            $auth->username => 'required|exists:users,' . $auth->username,
            "password" => 'sometimes|required'
        ]);

        if ($request->missing('password')){
            if (!$auth->getUser())
                return $this->respond($auth->failedLoginResponse());

            $auth->sendOtp();
            return $this->respond($auth->otpResponse());
        }

        if ($auth->attemptLogin())
            return $this->respond($auth->loginResponse());

        return $this->respond($auth->failedLoginResponse());
    }

    public function refresh(Request $request): JsonResponse
    {
        $auth = Authenticator::init($request);
        $auth->setUser($request->user());
        return $this->respond($auth->loginResponse());
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->has('all')){
            $request->user()->tokens()->delete();
        }else{
            $request->user()->currentAccessToken()->delete();
        }

        return $this->respond( 'logged out successfully');
    }

    public function user(Request $request): JsonResponse
    {
        return $this->respond($request->user());
    }
}