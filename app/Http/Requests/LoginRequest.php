<?php

namespace App\Http\Requests;

use App\Support\Constant;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest  extends BaseFormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
