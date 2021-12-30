<?php
// 应用公共文件
/**
 * 通用化API数据格式输出
 * @param $code 自定义状态码
 * @param string $message 信息
 * @param array $data 数据
 * @param int $statusCode 服务器状态码
 * @return \think\response\Json
 */
function msg($code, $message='error', $data = [], $statusCode = 200)
{
	$res = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    return json($res,$statusCode);
}