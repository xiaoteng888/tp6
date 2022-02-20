<?php
use app\demo\exceptions\InternalException;

// 容器Provider定义文件
return [
    'think\exception\Handle' => app\api\exceptions\InternalException::class,

];
