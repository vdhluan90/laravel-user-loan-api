<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use \Illuminate\Http\Response as Res;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends BaseController
{
    /**
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($data = null)
    {
        return Response::json(
            $data,
            Res::HTTP_CREATED
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNoContent()
    {
        return Response::json(null, Res::HTTP_NO_CONTENT);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data)
    {
        return Response::json(
            $data,
            Res::HTTP_OK
        );
    }

    /**
     * @param Paginator $paginate
     * @param           $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithPagination(Paginator $paginate, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $paginate->total(),
                'total_pages' => ceil($paginate->total() / $paginate->perPage()),
                'current_page' => $paginate->currentPage(),
                'limit' => $paginate->perPage(),
            ]
        ]);

        return Response::json(
            $data,
            Res::HTTP_OK
        );
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found')
    {
        return Response::json(
            [
                [
                    'message' => $message,
                ],
            ],
            Res::HTTP_NOT_FOUND
        );
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message)
    {
        return Response::json(
            [
                [
                    'errors' => [
                        'message' => $message
                    ]
                ],
            ],
            Res::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * @param $message
     * @param $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondValidationError($message, $errors)
    {
        return Response::json(
            [
                $errors,
                'errors' => [
                    'message' => $message
                ]
            ],
            Res::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return Response::json(
            [
                'errors' => [
                    'message' => $message
                ]
            ],
            Res::HTTP_UNAUTHORIZED
        );
    }
}
