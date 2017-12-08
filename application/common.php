<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function Api_json($data,$success='true',$msg="")
{
    $result=[
        "result"=>$data,//返回实际数据
        "success"=>$success,//失败是返回错误信息
        "errorMsg"=>$msg,//false代表服务器返回数据失败，true代表成功

    ];
    return Json($result);
}