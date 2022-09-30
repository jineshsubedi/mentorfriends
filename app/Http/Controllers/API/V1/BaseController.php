<?php

namespace App\Http\Controllers\API\V1;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;

class BaseController extends Controller
{
    public function __construct()
    {
    }
    /**
     * @var int
     */

    protected $statusCode = Res::HTTP_OK;
    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @param $message
     * @return json response
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respondCreated($message, $data=null){
        return $this->respond([
            'status' => 'success',
            'status_code' => Res::HTTP_CREATED,
            'message' => $message,
            'data' => $data
        ])->setStatusCode(Res::HTTP_CREATED);
    }

    /**
     * @param Paginator $paginate
     * @param $data
     * @return mixed
     */
    protected function respondWithPagination(Paginator $paginate, $data, $message){
        $data = array_merge($data, [
            'paginator' => [
                'total_count'  => $paginate->total(),
                'total_pages' => ceil($paginate->total() / $paginate->perPage()),
                'current_page' => $paginate->currentPage(),
                'limit' => $paginate->perPage(),
            ]
        ]);
        return $this->respond([
            'status' => 'success',
            'status_code' => Res::HTTP_OK,
            'message' => $message,
            'data' => $data
        ])->setStatusCode(Res::HTTP_OK);
    }

    public function respondNotFound($message = 'Not Found!'){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_NOT_FOUND,
            'message' => $message,
        ])->setStatusCode(Res::HTTP_NOT_FOUND);
    }

    public function respondInternalError($message){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $message,
        ])->setStatusCode(Res::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function respondValidationError($message, $errors){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $message,
            'data' => $errors
        ])->setStatusCode(Res::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function respond($data, $headers = []){
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function sendSuccessResponse($result, $message){
    	return $this->respond([
            'status' => 'success',
            'status_code' => Res::HTTP_OK,
            'message' => $message,
            'data'    => $result,
        ])->setStatusCode(Res::HTTP_OK);
    }

    public function respondNoContent($message){
        return $this->respond([
            'status' => 'success',
            'status_code' => Res::HTTP_NO_CONTENT,
            'message' => $message,
        ])->setStatusCode(Res::HTTP_NO_CONTENT);
    }

    public function respondWithError($message){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_BAD_REQUEST,
            'message' => $message,
        ])->setStatusCode(Res::HTTP_BAD_REQUEST);
    }

    public function respondWithUnauthorized($message){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_UNAUTHORIZED,
            'message' => $message,
        ])->setStatusCode(Res::HTTP_UNAUTHORIZED);
    }

    public function respondForbidden($message){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_FORBIDDEN,
            'message' => $message,
        ])->setStatusCode(Res::HTTP_FORBIDDEN);
    }
    public function respondWithGone($message){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_GONE,
            'message' => $message,
        ])->setStatusCode(Res::HTTP_GONE);
    }
}
