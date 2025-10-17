<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Domain\Services\AuthService;
use App\Traits\ApiResponse;
use App\Support\Constant;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\{
    LoginRequestV2,
    ValidateTokenRequest
};
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private AuthService $authService) {}

    public function login(LoginRequestV2 $request): JsonResponse
    {
       $token = $this->authService->loginWithEmail($request->email, $request->password);

        if (!$token) {
            return $this->responseJson(false, __('messages.auth_invalid_credentials'), [], Constant::HTTP_CODE_UNAUTHORIZED);
        }

        $response = [
            'access_token' => $token,
            'refresh_token' => base64_encode(str()->random(30))
        ];

        return $this->responseJson(true, __('messages.auth_login_success', ['version' => 'v2']), $response, Constant::HTTP_CODE_OK);
    }

    public function validateToken(ValidateTokenRequest $request): JsonResponse
    {
        $valid = $this->authService->validateToken($request->token);

        if (!$valid) {
            return $this->responseJson(false, __('messages.auth_token_invalid'), [], Constant::HTTP_CODE_UNAUTHORIZED);
        }

        return $this->responseJson(true, __('messages.token_valid', ['version' => 'v2']), ['token_valid' => true], Constant::HTTP_CODE_OK);
    }
}

