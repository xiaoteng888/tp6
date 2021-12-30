<?php


namespace app\admin\controller;


use think\captcha\Captcha;

class ImgCaptcha
{
    public function getCaptcha(Captcha $captcha)
    {
        return $captcha->create('my');
    }
}