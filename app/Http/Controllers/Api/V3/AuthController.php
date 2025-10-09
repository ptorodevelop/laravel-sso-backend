<?php
namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Services\AuthService;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}

    public function login(Request $request)
    {
        $request->validate(['codigoOTP' => 'required|string']);

        $token = $this->authService->loginWithOtp($request->codigoOTP);

        if(!$token) return response()->json(['message' => 'Código OTP inválido'], 401);

        return response()->json([ 'access_token' => $token, 'token_type' => 'bearer', 'expires_in' => "120" ]);
    }
}
