<?php
use app\demo\exceptions\InternalException;

// 容器Provider定义文件
return [
    'think\exception\Handle' => app\admin\exceptions\InternalException::class,
];
