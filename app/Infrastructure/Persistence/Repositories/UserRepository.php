<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findByDocument(string $document)
    {
        return User::where('document', $document)->first();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
