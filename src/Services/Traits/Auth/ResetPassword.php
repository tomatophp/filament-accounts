<?php

namespace TomatoPHP\FilamentAccounts\Services\Traits\Auth;

use Carbon\Carbon;
use TomatoPHP\FilamentAccounts\Events\SendOTP;
use TomatoPHP\FilamentAccounts\Helpers\Response;
use TomatoPHP\FilamentAccounts\Services\Contracts\WebResponse;

trait ResetPassword
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(\Illuminate\Http\Request $request,string $type="api"): \Illuminate\Http\JsonResponse|WebResponse
    {
        $request->validate([
            $this->loginBy => "required|exists:".app($this->model)->getTable().",username",
        ]);

        $checkIfActive = $this->model::where("username", $request->get($this->loginBy))->first();
        if ($checkIfActive) {
            $checkIfActive->otp_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $checkIfActive->save();

            SendOTP::dispatch($this->model, $checkIfActive->id);

            if($type === 'api'){
                return Response::success(__('An OTP Has been send to your ').$this->loginType . __(' please check it'));
            }
            else {
                return WebResponse::make(__('An OTP Has been send to your ').$this->loginType . __(' please check it'))->success();
            }

        }

        if($type === 'api'){
            return Response::errors(__('user not found'), 404);
        }
        else {
            return WebResponse::make(__('user not found'))->error();
        }
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(\Illuminate\Http\Request $request,string $type="api"): \Illuminate\Http\JsonResponse|WebResponse
    {
        if($type === 'web'){
            $user = auth($this->guard)->user();
        }
        else {
            $user = $request->user();
        }

        if($user){
            $request->validate([
                'password' => "required|confirmed|min:6|max:191",
            ]);

            $user->password = bcrypt($request->get('password'));
            $user->save();

            if($type === 'api'){
                return Response::success(__("Password Updated"));
            }
            else {
                return WebResponse::make(__("Password Updated"))->success();
            }

        }
        else {
            $request->validate([
                'password' => "required|confirmed|min:6|max:191",
                'otp_code' => 'required|string|max:6|exists:'.app($this->model)->getTable().',otp_code',
                $this->loginBy => 'required|string|max:255|exists:'.app($this->model)->getTable().',username',
            ]);

            $user = app($this->model)->where("username", $request->get($this->loginBy))->first();

            if ($user) {
                if ((!empty($user->otp_code)) && ($user->otp_code === $request->get('otp_code'))) {
                    $user->otp_activated_at = Carbon::now();
                    $user->otp_code = null;
                    $user->password = bcrypt($request->get('password'));
                    $user->save();

                    if($type === 'api'){
                        return Response::success(__("Password Updated"));
                    }
                    else {
                        return WebResponse::make(__("Password Updated"))->success();
                    }
                }

                if($type === 'api'){
                    return Response::errors(__('sorry this code is not valid or expired'));
                }
                else {
                    return WebResponse::make(__('sorry this code is not valid or expired'));
                }

            }

            if($type === 'api'){
                return Response::errors(__('user not found'), 404);
            }
            else {
                return WebResponse::make(__('user not found'));
            }

        }
    }
}
