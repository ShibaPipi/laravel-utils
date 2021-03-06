<?php
/**
 *
 * User: sun.yaopeng
 * Date: 2020/10/29
 */

namespace Shibapipi\Utils\ApiResponse\Responses;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class NotFound extends Response
{
    protected $code = FoundationResponse::HTTP_NOT_FOUND;
    protected $status = 'error';
}
