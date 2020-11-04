<?php

namespace Shibapipi\Utils\ApiResponse;

use Shibapipi\Utils\ApiResponse\Exceptions\ResponseClassNotFoundException;
use Shibapipi\Utils\ApiResponse\Responses\Response;

/**
 * Class ApiResponseHandler
 * @package Shibapipi\Utils\ApiResponse
 * @method ok($data)
 * @method createdOrUpdated($data = [])
 * @method noContent(string $message = '')
 * @method badRequest(string $message = '')
 * @method notFound(string $message = '')
 * @method internalServerError(string $message = '')
 */
class ApiResponseHandler
{
    /**
     * @param $method
     * @param $arguments
     * @return \Illuminate\Http\JsonResponse
     * @throws ResponseClassNotFoundException
     */
    public function __call($method, $arguments)
    {
        $clsName = __NAMESPACE__ . '\\Responses\\' . ucfirst($method);
        $responseCls = new $clsName();
        if (!($responseCls instanceof Response)) {
            throw new ResponseClassNotFoundException();
        }

        switch ($method) {
            case 'ok':
            case 'createdOrUpdated':
                if ($arguments) {
                    $responseCls->setData($arguments[0]);
                }
                break;
            case 'respond':
            default:
                $responseCls->setMessage($arguments ? $arguments[0] : '');
                break;
        }

        return $this->respond($responseCls->toArray());
    }

    /**
     * @param array $responseClsData
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond(array $responseClsData = [])
    {
        if (config('app.debug') && $this->debugEnabled()) {
            $responseClsData += $this->getDebug();
        }
        return response()->json($responseClsData, $responseClsData['code']);
    }

    protected function debugEnabled()
    {
        return app()->has('debugbar') && app('debugbar')->isEnabled();
    }

    protected function getDebug()
    {
        return ['_debugbar' => app('debugbar')->getData()];
    }
}
