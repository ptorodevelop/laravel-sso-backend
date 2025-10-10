<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Support\Constant;
use App\Traits\ApiResponse;
use App\Domain\Services\AuthService;
use App\Infrastructure\Notifications\EmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Http\Requests\{
    LoginRequestV3
};

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private AuthService $authService) {}


    public function login(LoginRequestV3 $request)
    {
        $request->validate(['codigoOTP' => 'required|string']);
        $token = $this->authService->loginWithOtp($request->codigoOTP);
        if (! $token) {
            return $this->responseJson(false, 'Código OTP inválido o expirado', [], Constant::HTTP_CODE_UNAUTHORIZED);
        }
        $response = ['access_token' => $token, 'refresh_token' => base64_encode(str()->random(30))];
        return $this->responseJson(true, 'Inicio de sesión exitoso (v3)', $response, Constant::HTTP_CODE_OK);
    }
}
