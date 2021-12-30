<?php
/*系统内部异常类*/
namespace app\exceptions;

use Exception;
use think\Response;
use Throwable;
class InvalidRequestException extends Exception
{
    public function __construct(string $msg = '',int $code = 400)
    {
        parent::__construct($msg,$code);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        //判断是不是AJAX请求
        if($request->isAjax()){
            //json() 方法第二个参数就是 Http 返回码
            return msg(config('statusCode.error'),$this->message,[],$this->code);
        }
        return msg(config('statusCode.error'),$e->getMessage(),[],$this->code);

        //return view('pages.error',['msg' => $this->msgForUser]);
    }
}
