<?php
namespace app\admin\controller;

class Error {
	public function __call($name,$arguments)
	{
		return msg(config('statusCode.controller_is_not_found'),"控制器不存在",null,404);
	}
}