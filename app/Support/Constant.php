<?php

namespace App\Support;

class Constant
{

    public const HTTP_CODE_OK = 200;
    public const HTTP_CODE_CREATED = 201;
    public const HTTP_CODE_NO_CONTENT = 204;
    public const HTTP_CODE_BAD_REQUEST = 400;
    public const HTTP_CODE_UNAUTHORIZED = 401;
    public const HTTP_CODE_FORBIDDEN = 403;
    public const HTTP_CODE_NOT_FOUND = 404;
    public const HTTP_CODE_METHOD_NOT_ALLOWED = 405;
    public const HTTP_CODE_CONFLICT = 409;
    public const HTTP_CODE_UNPROCESSABLE_CONTENT = 422;
    public const HTTP_CODE_INTERNAL_SERVER_ERROR = 500;

    public const RESPONSE_SUCCESS = 'success';
    public const RESPONSE_MESSAGE = 'message';
    public const RESPONSE_DATA = 'data';
}
