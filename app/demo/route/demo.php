<?php

use think\facade\Route;

Route::rule("test","index/abc","GET");
Route::rule("test1","e/middle","GET")->middleware(\app\demo\middleware\E::class);