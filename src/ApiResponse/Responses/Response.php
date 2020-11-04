<?php
/**
 *
 * User: sun.yaopeng
 * Date: 2020/10/29
 */

namespace Shibapipi\Utils\ApiResponse\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class Response implements Arrayable
{
    /**
     * @var int $code
     */
    protected $code;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $message
     */
    protected $message = '';

    /**
     * @var $data
     */
    protected $data = null;

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message = '')
    {
        $this->message = $message ?: FoundationResponse::$statusTexts[$this->code];

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function toArray()
    {
        return [
            'code' => $this->code,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data];
    }
}
