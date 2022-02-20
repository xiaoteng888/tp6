<?php


namespace app\admin\controller;


use app\Request;
use think\Exception;
use think\exception\ValidateException;
use think\facade\Filesystem;

class Image extends AdminBase
{
    public function upload(Request $request)
    {
        if(!$request->isPost()){
            return msg(config('statusCode.error'),'请求不合法');
        }
        $file = $request->file('file');
        try {
            validate(['file' => config('upload')])->check(['file' => $file]);

                $filename = Filesystem::disk('public')->putFile('image', $file);

        }catch (ValidateException $e){
            return msg(config('statusCode.error'),$e->getError());
        }

        if(!$filename){
            return msg(config('statusCode.error'),'上传失败');
        }
        $imgUrl = [
            'image' => '/upload/'.$filename,
        ];
        return msg(config('statusCode.success'),'上传成功',$imgUrl);
    }

    public function layUpload(Request $request)
    {
        if(!$request->isPost()){
            return msg(config('statusCode.error'),'请求不合法');
        }
        $file = $request->file('file');
        try {
            validate(['file' => config('upload')])->check(['file' => $file]);
            $filename = Filesystem::disk('public')->putFile('image',$file);
        }catch (ValidateException $e){
            return msg(config('statusCode.error'),$e->getError());
        }
        if(!$filename){
            return json(['code' =>1,'data' => []],200);
            //return msg(config('statusCode.error'),'上传失败');
        }

        return json(['code' => 0,'data' => ['src' => '/upload/'.$filename]],200);
    }
}