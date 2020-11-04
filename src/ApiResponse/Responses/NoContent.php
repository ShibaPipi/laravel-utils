<?php
/**
 *
 * User: sun.yaopeng
 * Date: 2020/10/29
 */

namespace Shibapipi\Utils\ApiResponse\Responses;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

class NoContent extends Response
{
    protected $code = FoundationResponse::HTTP_NO_CONTENT;
    protected $status = 'success';
}
