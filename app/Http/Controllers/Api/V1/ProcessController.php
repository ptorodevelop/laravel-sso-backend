<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\Constant;
use App\Traits\ApiResponse;

class ProcessController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->responseJson(true, 'Operación exitosa', ['message' => 'Acceso exitoso a proceso restringido version v1'], Constant::HTTP_CODE_OK);
    }
}
