<?php
/**
 * Created by BrainMaestro
 * Date: 4/3/2016
 * Time: 7:57 PM.
 */
namespace Fce\Utility;

use Illuminate\Http\Response;

trait ApiClient
{
    /**
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message)
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
            ->respondWithError($message, 'Not Found');
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondBadRequest($message)
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
            ->respondWithError($message, 'Bad Request');
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalServerError($message)
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message, 'Internal Server Error');
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondUnprocessable($message)
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithError($message, 'Unprocessable Entity');
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorized($message)
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)
            ->respondWithError($message, 'Unauthorized');
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondForbidden($message)
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)
            ->respondWithError($message, 'Forbidden');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function respondCreated($data = [])
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->respond($data);
    }

    /**
     * @param string|array $data
     * @return mixed
     */
    public function respondSuccess($data = 'Operation Successful')
    {
        $this->setStatusCode(Response::HTTP_OK);

        if (is_string($data)) {
            return $this->respond([
                'data' => [
                    'message' => $data,
                ],
            ]);
        }

        return $this->respond($data);
    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    private function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param string $message
     * @param string $status
     * @return mixed
     */
    private function respondWithError($message, $status)
    {
        return $this->respond([
            'error' => [
                'status' => $status,
                'code' => $this->getStatusCode(),
                'message' => $message,
            ],
        ]);
    }
}
