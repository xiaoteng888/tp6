<?php

namespace app\common\lib;

class Msg {

    public static function success($data=[],$message = 'OK')
    {
        $res = [
            'status' => config('statusCode.success'),
            'message' => $message,
            'result' => $data,
        ];
        return json($res);
    }

    public static function error($message = 'ERROR',$status = 0,$data=[])
    {
        $res = [
            'status' => $status,
            'message' => $message,
            'result' => $data,
        ];
        return json($res);
    }
}
