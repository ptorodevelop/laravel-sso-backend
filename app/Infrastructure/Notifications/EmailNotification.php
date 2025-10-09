<?php
namespace App\Infrastructure\Notifications;

use App\Domain\Services\NotificationStrategyInterface;
use Illuminate\Support\Facades\Mail;

class EmailNotification implements NotificationStrategyInterface
{
    public function send(string $destino, string $mensaje): bool
    {
        Mail::raw($mensaje, function($m) use ($destino){
            $m->to($destino)->subject('Notificación SSO');
        });
        return true;
    }
}
