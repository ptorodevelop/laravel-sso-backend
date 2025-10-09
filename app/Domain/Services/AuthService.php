<?php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function loginWithDocument(string $document, string $password)
    {
        $user = $this->users->findByDocument($document);
        if(!$user || !Hash::check($password, $user->password)) {
            return null;
        }
        return JWTAuth::fromUser($user);
    }

    public function loginWithEmail(string $email, string $password)
    {
        $user = $this->users->findByEmail($email);
        if(!$user || !Hash::check($password, $user->password)) {
            return null;
        }
        return JWTAuth::fromUser($user);
    }

    public function loginWithOtp(string $codigo)
    {
        $payload = cache()->get('otp:'.$codigo);
        if(!$payload) return null;

        $user = $this->users->findByEmail($payload['email'] ?? '');
        if(!$user) return null;

        cache()->forget('otp:'.$codigo);

        return JWTAuth::fromUser($user);
    }

    public function validateToken(string $token): bool
    {
        try {
            $payload = JWTAuth::setToken($token)->toUser();
            return $payload !== null;
        } catch (\Exception $e) {
            return false;
        }
    }
}
