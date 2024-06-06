<?php

namespace TomatoPHP\FilamentAccounts\Responses;

use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class RegisterResponse implements RegistrationResponse
{
    public function toResponse($request)
    {
        $email = $request->get('components')[0]['updates']['data.email'];
        return redirect()->to(url('otp?email='.$email));
    }
}
