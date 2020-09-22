<?php

namespace Shibapipi\Utils;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode, $httpCode = null)
    {
        $this->statusCode = $httpCode ?? $statusCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        return response()->json($data, $this->getStatusCode(), $header);
    }

    protected function debugEnabled()
    {
        return app()->has('debugger') && app('debugger')->isEnabled();
    }

    protected function getDebug()
    {
        return ['_debugger' => app('debugger')->getData()];
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data, $code = null)
    {
        if ($code) {
            $this->setStatusCode($code);
        }

        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];

        $data = array_merge($status, $data);

        return $this->respond($data);

    }

    /**
     * 格式
     * data:
     * code:422, message:xxx, status:'error'
     *
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message, $status = 'success')
    {
        return $this->status($status, compact('message'));
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = 'Internal Error!')
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function createdOrUpdated($message = 'created or updated')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function deleted($message = 'deleted')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_NO_CONTENT)
            ->message($message);
    }

    /**
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function success($data, $status = 'success')
    {
        return $this->status($status, compact('data'));
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFound($message = 'Not Found!')
    {
        return $this->failed($message, Foundationresponse::HTTP_NOT_FOUND);
    }

    /**
     * @param ResourceCollection $collection
     * @return ResourceCollection
     */
    public function resource(ResourceCollection $collection)
    {
        $additional = [
            'code' => $this->statusCode,
        ];

        if ($this->debugEnabled()) {
            $additional += $this->getDebug();
        }

        $collection->additional($additional);

        return $collection;
    }
}
