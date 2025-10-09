<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Infrastructure\Notifications\EmailNotification;
use App\Infrastructure\Notifications\SmsNotification;
use App\Infrastructure\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use App\Support\Constant;
use App\Traits\ApiResponse;
use App\Http\Requests\SendNotificationRequest;


class NotificationController extends Controller
{
    use ApiResponse;

    public function send(SendNotificationRequest $request)
    {
        $strategy = match ($request->canal) {
            'email' => new EmailNotification,
            'sms' => new SmsNotification,
            'telegram' => new TelegramNotification,
            default => null
        };

        if (! $strategy) {
            return $this->responseJson(false, 'Canal no soportado', [], Constant::HTTP_CODE_BAD_REQUEST);
        }

        try {
            $ok = $strategy->send($request->destino, $request->mensaje);

            if ($ok) {
                return $this->responseJson(true, 'Notificación enviada correctamente', ['sent' => true], Constant::HTTP_CODE_OK);
            } else {
                return $this->responseJson(false, 'Error al enviar la notificación',['sent' => false], Constant::HTTP_CODE_INTERNAL_SERVER_ERROR);
            }
        } catch (\Throwable $e) {
            return $this->responseJson(false,'Error inesperado: '.$e->getMessage(),[], Constant::HTTP_CODE_INTERNAL_SERVER_ERROR);
        }

    }
}
