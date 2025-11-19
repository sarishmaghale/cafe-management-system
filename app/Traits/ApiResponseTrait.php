<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($message = null, $data = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message ?? 'Success',
            'data' => $data,
        ], $code);
    }
    protected function errorResponse($message = null, $errors = null, $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? 'Error',
            'error' => $errors,
        ], $code);
    }
}
