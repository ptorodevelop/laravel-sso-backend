<?php
namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $token = $this->authService->loginWithEmail($request->email, $request->password);

        if(!$token) return response()->json(['message' => 'Credenciales inválidas'], 401);

        return response()->json([ 'access_token' => $token, 'token_type' => 'bearer', 'expires_in' => "120" ]);
    }
}
