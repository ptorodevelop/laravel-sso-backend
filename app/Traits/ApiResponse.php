<?php

namespace App\Traits;

use App\Support\Constant;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function responseJson(
        bool $success,
        string $message = '',
        mixed $data = null,
        int $status = Constant::HTTP_CODE_OK
    ): JsonResponse {
        return response()->json([
            Constant::RESPONSE_SUCCESS => $success,
            Constant::RESPONSE_MESSAGE => $message,
            Constant::RESPONSE_DATA => $data,
        ], $status);
    }
}
