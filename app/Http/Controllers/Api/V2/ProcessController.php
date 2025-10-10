<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\Constant;
use Illuminate\Http\JsonResponse;

class ProcessController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $metadata = [
            'version' => 'v2',
            'timestamp' => now()->toDateTimeString(),
            'environment' => config('app.env')
        ];

        $data = [
            'message' => 'Acceso exitoso a proceso restringido versión 2',
            'meta' => $metadata
        ];

        return $this->responseJson(true, 'Proceso autorizado (v2)', $data, Constant::HTTP_CODE_OK);
    }
}
