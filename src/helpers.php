<?php
/**
 * 自定义助手函数
 *
 * User: Shibapipi
 * Date: 2020/4/27
 */

use Shibapipi\Utils\ApiResponse\ApiResponseHandler as ApiResponse;

if (!function_exists('api_response')) {
    /**
     * 处理 api / ajax 形式的返回结果。
     * User: Shibapipi
     * Date: 2020-04-27
     *
     * @return ApiResponse
     */
    function api_response(): ApiResponse
    {
        return app(ApiResponse::class);
    }
}

if (!function_exists('make_table_comment')) {
    /**
     * 给一个数据表添加注释。
     *
     * User: Shibapipi
     * Date: 2020-04-27
     *
     * @param string $tableName 表名
     * @param string $comment 注释内容
     * @return string
     */
    function make_table_comment($tableName, $comment): string
    {
        return "ALTER TABLE `" . config('database.connections.mysql.prefix') . $tableName . "` COMMENT '" . $comment . "'";
    }
}

if (!function_exists('build_query_where')) {
    /**
     * 将传入的字段和查询条件运算符转换为 ORM 的查询条件数组。
     *
     * User: Shibapipi
     * Date: 2020-05-08
     *
     * @param array $where
     * @return array
     */
    function build_query_where(array $where): array
    {
        $whereBuilder = [];
        $request = request()->all();

        foreach ($where as $key => $value) {
            if (!isset($request[$value]) || !$request[$value]) {
                continue;
            }

            if (is_int($key)) {
                $whereBuilder[] = [$value, $request[$value]];
            } else {
                if ('like' === $key) {
                    $whereBuilder[] = [$value, $key, '%' . $request[$value] . '%'];
                } else {
                    $whereBuilder[] = [$value, $key, $request[$value]];
                }
            }
        }

        return $whereBuilder;
    }
}

if (!function_exists('request_os')) {
    /**
     * 解析 user-agent，获取操作系统
     * @param string $userAgent
     * @return string
     */
    function request_os(string $userAgent): string
    {
        $os = 'unknown';
        if (preg_match('/linux/i', $userAgent)) {
            $os = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $os = 'mac';
        } elseif (preg_match('/windows|win32/i', $userAgent)) {
            $os = 'windows';
        }

        return $os;
    }
}

if (!function_exists('request_browser')) {
    /**
     * 解析 user-agent，获取浏览器名称
     * @param string $userAgent
     * @return string
     */
    function request_browser(string $userAgent): string
    {
        $browser = 'unknown';
        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Netscape/i', $userAgent)) {
            $browser = 'Netscape';
        }

        return $browser;
    }
}

if (!function_exists('rich_to_text')) {
    /**
     * 将字符串中的一些预定义的 HTML 实体转换为字符
     * 将字符串中的空格替换成空
     * 去除字符串中的 HTML、XML 以及 PHP 的标签，获取纯文本内容
     * @param string $richText
     * @return string
     */
    function rich_to_text(string $richText)
    {
        return strip_tags(str_replace(['&nbsp;', '&ldquo;', '&rdquo;'], '', htmlspecialchars_decode($richText)));
    }
}
