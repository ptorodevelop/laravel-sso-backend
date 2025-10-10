<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    LoginRequest,
    ValidateTokenRequest
};
use App\Support\Constant;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        $token = $this->authService->loginWithDocument($request->document, $request->password);
        if (! $token) {
            return $this->responseJson(false, 'Credenciales inválidas', [], Constant::HTTP_CODE_UNAUTHORIZED);
        }
        $response = ['access_token' => $token, 'refresh_token' => base64_encode(str()->random(30))];

        return $this->responseJson(true, 'Inicio de sesión exitoso (V1)', $response, Constant::HTTP_CODE_OK);
    }

    public function validateToken(ValidateTokenRequest $request)
    {
        $valid = $this->authService->validateToken($request->token);
        if (! $valid) {
            return $this->responseJson(false, 'Token inválido', ['valid' => false], Constant::HTTP_CODE_UNAUTHORIZED);
        }
        return $this->responseJson(true, 'Token válido', ['valid' => true], Constant::HTTP_CODE_OK);
    }
}
