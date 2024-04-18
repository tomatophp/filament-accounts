<?php

namespace TomatoPHP\FilamentAccounts\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static guard(string $guard)
 * @method static requiredOtp(bool $otp)
 * @method static model(string $model)
 * @method static loginBy(string $loginBy)
 * @method static loginType(string $loginType)
 * @method static resource(string $resource)
 * @method static createValidation(array $createValidation)
 * @method static updateValidation(array $updateValidation)
 * @method \Illuminate\Http\JsonResponse login(\Illuminate\Http\Request $request, string $type = "api")
 * @method \Illuminate\Http\JsonResponse logout(\Illuminate\Http\Request $request, string $type = "api")
 * @method \Illuminate\Http\JsonResponse otp(\Illuminate\Http\Request $request, string $type = "api")
 * @method \Illuminate\Http\JsonResponse register(\Illuminate\Http\Request $request, array $validation=[], string $type = "api")
 * @method \Illuminate\Http\JsonResponse reset(\Illuminate\Http\Request $request, string $type = "api")
 * @method \Illuminate\Http\JsonResponse password(\Illuminate\Http\Request $request, string $type = "api")
 * @method \Illuminate\Http\JsonResponse resend(\Illuminate\Http\Request $request, string $type = "api")
 * @method \Illuminate\Http\JsonResponse profile(\Illuminate\Http\Request $request, string $type = "api")
 * @method \Illuminate\Http\JsonResponse update(\Illuminate\Http\Request $request, array $validation=[], string $type = "api")
 * @method \Illuminate\Http\JsonResponse destroy(\Illuminate\Http\Request $request, string $type = "api")
 */
class FilamentAccountsAuth extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'filament-accounts-auth';
    }
}
