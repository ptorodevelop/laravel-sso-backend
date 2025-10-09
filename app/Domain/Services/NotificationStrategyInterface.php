<?php
namespace App\Domain\Services;

interface NotificationStrategyInterface {
    public function send(string $destino, string $mensaje): bool;
}
