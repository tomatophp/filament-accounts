<?php

namespace TomatoPHP\FilamentAccounts\Services\Traits\Auth;

use TomatoPHP\FilamentAccounts\Events\SendOTP;
use TomatoPHP\FilamentAccounts\Events\AccountRegistered;
use TomatoPHP\FilamentAccounts\Helpers\Response;
use TomatoPHP\FilamentAccounts\Services\Contracts\WebResponse;

trait Register
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(\Illuminate\Http\Request $request, array $validation=[], ?string $resource=null,string $type="api"): \Illuminate\Http\JsonResponse|WebResponse
    {
        $request->validate(
            array_merge([
                "password" => "required|confirmed|min:6|max:191"
            ], $this->createValidation, $validation)
        );

        $data = $request->all();

        if($this->loginBy === 'phone'){
            $data['username'] = $request->get('phone');
        }
        elseif($this->loginBy === 'email'){
            $data['username'] = $request->get('email');
        }

        $data['password'] = bcrypt($request->get('password'));

        $user = app($this->model)->create($data);

        if ($user) {
            //Set More Data to Meta
            foreach ($request->all() as $key => $value) {
                if (!in_array($key, ['password', 'password_confirmation', 'username', 'name'])) {
                    $user->meta($key, $value);
                }
            }
            if($this->otp){
                $user->otp_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                $user->save();

                SendOTP::dispatch($this->model, $user->id);
                AccountRegistered::dispatch($this->model, $user->id);

                if($type === 'api'){
                    return Response::success('An OTP Has been send to your '.$this->loginType . ' please check it');
                }
                else {
                    return WebResponse::make('An OTP Has been send to your '.$this->loginType . ' please check it')->success();
                }
            }

            $token = $user->createToken($this->guard)->plainTextToken;
            $user->token = $token;

            AccountRegistered::dispatch($this->model, $user->id);
            if($this->resource){
                $user = $this->resource::make($user);
            }
            if($type === 'api'){
                return Response::data($user, __('User registration success'));
            }
            else {
                return WebResponse::make(__('User registration success'))->success();
            }

        }

        if($type === 'api'){
            return Response::errors('User registration failed');
        }
        else {
            return WebResponse::make(__('User registration failed'))->success();
        }

    }

}
