<?php

namespace TomatoPHP\FilamentAccounts\Services\Traits\Profile;

use TomatoPHP\FilamentAccounts\Helpers\Response;
use TomatoPHP\FilamentAccounts\Services\Contracts\WebResponse;

trait Logout
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(\Illuminate\Http\Request $request, string $type = "api"): \Illuminate\Http\JsonResponse|WebResponse
    {
        auth($this->guard)->logout();

        if($type === 'api'){
            $user = $this->model::find($request->user()->id);
            $user->tokens()->delete();

            return Response::success("Logout Success");
        }
        else {
            return WebResponse::make(__('Logout Success'))->success();
        }
    }
}
