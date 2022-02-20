<?php
/*系统内部异常类*/
namespace app\api\exceptions;

use think\Exception;
use think\exception\HttpResponseException;
use think\Response;
use Throwable;
use think\exception\Handle;
class InternalException extends Handle
{
    public $httpCode = 400;
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
        // 添加自定义异常处理机制
        //不可预知的内部异常处理
        if(method_exists($e,"getStatusCode")){
            $httpCode = $e->getStatusCode();
        }else{
            $httpCode = $this->httpCode;
        }

        if($e instanceof HttpResponseException){
            //return $e->getResponse();
            return  parent::render($request,$e);
        }
        if($e instanceof Exception){
            return msg($e->getCode(),$e->getMessage(),[],$httpCode);
        }
        return msg(config('statusCode.error'),$e->getMessage(),[],$httpCode);
    }
}
