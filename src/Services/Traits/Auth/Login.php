<?php

namespace TomatoPHP\FilamentAccounts\Services\Traits\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\FilamentAccounts\Helpers\Response;
use TomatoPHP\FilamentAccounts\Services\Contracts\WebResponse;

trait Login
{

    public function login(\Illuminate\Http\Request $request,string $type="api"): Model|JsonResponse|WebResponse
    {
        $request->validate([
            $this->loginBy => "required|string|max:191",
            "password" => "required|string|min:6|max:191",
            "remember_me" => "nullable|bool",
        ]);


        $check = auth($this->guard)->attempt([
            "username" => $request->get($this->loginBy),
            "password" => $request->get('password')
        ]);

        if($check){
            $user = auth($this->guard)->user();
            if($user->is_active && $this->otp){
                $token = $user->createToken($this->guard)->plainTextToken;
                $user->token = $token;

                if($type === 'api'){
                    return $user;
                }
                else {
                    return WebResponse::make(__("Login Success"))->success();
                }
            }
            else if(!$user->is_active && $this->otp){
                auth($this->guard)->logout();

                if($type === 'api'){
                    return Response::errors(__("Your account is not active yet"));
                }
                else {
                    return WebResponse::make(__("Your account is not active yet"));
                }

            }
            else if(!$this->otp) {
                if($type === 'api'){
                    $token = $user->createToken($this->guard)->plainTextToken;
                    $user->token = $token;
                    if($this->resource){
                        $user = $this->resource::make($user);
                    }
                    return Response::data($user, __('Login Success'));
                }
                else {
                    return WebResponse::make(__("Login Success"))->success();
                }
            }
        }

        if($type === 'api'){
            return Response::errors(__("Username Or Password Is Not Correct"));
        }
        else {
            return WebResponse::make(__("Username Or Password Is Not Correct"));
        }

    }
}
