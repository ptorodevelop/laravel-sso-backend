<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendNotificationRequest;
use App\Infrastructure\Notifications\EmailNotification;
use App\Infrastructure\Notifications\SmsNotification;
use App\Infrastructure\Notifications\TelegramNotification;
use App\Support\Constant;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Cache;
use App\Domain\Repositories\UserRepositoryInterface;



class NotificationController extends Controller
{
    use ApiResponse;

    public function __construct(private UserRepositoryInterface $users) {}

    public function send(SendNotificationRequest $request)
    {
        $user = $this->users->findByEmail($request->destino);

        if (!$user) {
            return $this->responseJson(false, 'El destinatario no existe en el sistema.', [],Constant::HTTP_CODE_NOT_FOUND);
        }

        $strategy = match ($request->canal) {
            'email' => new EmailNotification(),
            'sms' => new SmsNotification(),
            'telegram' => new TelegramNotification(),
            default => null,
        };

        if (!$strategy) {
            return $this->responseJson(false, 'Canal no soportado', [], Constant::HTTP_CODE_BAD_REQUEST);
        }

        try {
                $ttl = (int) env('OTP_TTL', Constant::OTP_TTL);
                $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                Cache::put('otp:' . $otp, ['email' => $request->destino], now()->addMinutes(2));
                $mensaje = "Tu código OTP es: {$otp}. Este código es válido por {$ttl} minutos. No lo compartas con nadie.";
                $ok = $strategy->send($request->destino, $mensaje);

            if ($ok) {
                return $this->responseJson(
                    true,
                    'Notificación enviada correctamente',
                    ['sent' => true, 'destino' => $request->destino, 'mensaje' => $mensaje],
                    Constant::HTTP_CODE_OK
                );
            }

            return $this->responseJson(
                false,
                'Error al enviar la notificación',
                ['sent' => false],
                Constant::HTTP_CODE_INTERNAL_SERVER_ERROR
            );
        } catch (\Throwable $e) {
            return $this->responseJson(
                false,
                'Error inesperado: ' . $e->getMessage(),
                [],
                Constant::HTTP_CODE_INTERNAL_SERVER_ERROR
            );
        }
    }
}
