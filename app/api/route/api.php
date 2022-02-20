<?php

use think\facade\Route;
use think\middleware\Throttle;

Route::group(function(){
    Route::rule('smscode','Sms/send','post');
    Route::resource('user','User');
    Route::rule('logout','User/logout','delete');
})->middleware(\think\middleware\Throttle::class);
//登录
    Route::rule('login','Login/login','post');
    Route::get('category/search/:id', 'Category/search');
    Route::get('subcategory/:id', 'Category/sub');
    Route::get('lists','mall.Lists/index');
    Route::get('detail/:id','mall.Detail/index');