<?php
namespace App\Domain\Repositories;

use App\Infrastructure\Persistence\Models\User;

interface UserRepositoryInterface
{
    public function findByDocument(string $document);
    public function findByEmail(string $email);
}
