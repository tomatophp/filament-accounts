<?php

namespace TomatoPHP\FilamentAccounts\Helpers;

use \Illuminate\Support\Facades\Route;

class AuthRoutes
{
    public static function load(string $guard, string $controller):void
    {
        static::pub($guard, $controller);
        static::pri($guard, $controller);
    }

    public static function pub(string $guard, string $controller): void
    {
        Route::prefix('auth/'.$guard)->name('auth.' . $guard  .'.')->group( function () use ($controller) {
            Route::post('register', [$controller, 'register'])->name('register');
            Route::post('login', [$controller,'login'])->name('login');
            Route::post('check', [$controller,'check'])->name('check');
            Route::post('reset', [$controller,'reset'])->name('reset');
            Route::post('resend', [$controller,'resend'])->name('resend');
            Route::post('otp', [$controller,'otp'])->name('otp');
        });
    }

    public static function pri(string $guard, string $controller): void
    {
        Route::middleware("auth:sanctum")->prefix('auth/'.$guard)->name('auth.' . $guard  .'.')->group(function () use ($controller) {
            Route::get('profile', [$controller,'profile'])->name('profile');
            Route::post('update',[$controller,'update'])->name('update');
            Route::post('edit', [$controller,'edit'])->name('edit');
            Route::post('password', [$controller,'password'])->name('password');
            Route::delete('destroy', [$controller,'destroy'])->name('destroy');
            Route::post('logout', [$controller,'logout'])->name('logout');
        });
    }
}
