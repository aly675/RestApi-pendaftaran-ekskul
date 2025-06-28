<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class JsonResponseHelper
{
    /**
     * Return response sukses standar.
     *
     * @param string $model
     * @param string $call
     * @param mixed $values
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($values, $code = 200)
    {
        return response()->json([
            'params' => [
                'model' => $model,
                'call' => $call,
                'values' => $values,
            ]
        ], $code);
    }

    /**
     * Return response error standar.
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message, $code = 400)
    {
        return response()->json([
            'error' => [
                'code' => $code,
                'message' => $message,
            ]
        ], $code);
    }

    /**
     * Return response dengan pagination.
     *
     * @param string $model
     * @param string $call
     * @param LengthAwarePaginator $paginator
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function paginated($model, $call, LengthAwarePaginator $paginator, $code = 200)
    {
        return response()->json([
            'params' => [
                'model' => $model,
                'call' => $call,
                'values' => $paginator->items(),
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ],
            ]
        ], $code);
    }
}
