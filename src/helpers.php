<?php
/**
 * 自定义助手函数
 *
 * User: Shibapipi
 * Date: 2020/4/27
 */

use Shibapipi\Utils\ApiResponse;

if (!function_exists('mb_str_split')) {
    /**
     * 把字符串拆散成数组，支持中文汉字
     * User: Shibapipi
     * Date: 2020-07-17
     *
     * @param string $string
     * @return array
     */
    function mb_str_split(string $string): array
    {
        return preg_split('/(?<!^)(?!$)/u', $string);
    }
}

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
