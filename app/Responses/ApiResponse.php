<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public function __construct(
        private string $message,
        private array $data,
        private int $statusCode
    )
    {
    }

    public static function success(string $message, array $data = [], int $statusCode = 200): self
    {
        return new self($message, $data, $statusCode);
    }

    public static function error(string $message, $data = null, int $statusCode = 400): self
    {
        return new self($message, is_array($data) ? $data : ['error' => $data], $statusCode);
    }

    public function toJson(): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }
}
