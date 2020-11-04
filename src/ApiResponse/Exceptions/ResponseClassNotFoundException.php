<?php
/**
 *
 * User: sun.yaopeng
 * Date: 2020/10/29
 */

namespace Shibapipi\Utils\ApiResponse\Exceptions;

use Exception;

class ResponseClassNotFoundException extends Exception
{
    protected $message = 'Called Response Class Not Found.';
}
