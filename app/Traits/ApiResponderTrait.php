<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

trait ApiResponderTrait
{
    /**
     * @param string $message
     * @param array|object $data
     * @param int $code
     * @return JsonResponse
     */
    public function success(
        string       $message,
        array|object $data,
        int          $code = HttpFoundationResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
            'data'    => $data,
            'code'    => $code
        ], $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function fail(
        string $message,
        int $code = HttpFoundationResponse::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
            'code'    => $code
        ], $code);
    }
}
