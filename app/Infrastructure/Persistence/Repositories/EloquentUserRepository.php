<?php
namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByDocument(string $document): ?User
    {
        return User::where('document', $document)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}
