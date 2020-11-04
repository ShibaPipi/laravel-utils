<?php
/**
 *
 * User: sun.yaopeng
 * Date: 2020/10/29
 */

namespace Shibapipi\Utils\ApiResponse\Responses;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class BadRequest extends Response
{
    protected $code = FoundationResponse::HTTP_BAD_REQUEST;
    protected $status = 'error';
}
