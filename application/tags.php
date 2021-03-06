<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用行为扩展定义文件
return [
    // 应用初始化
    'app_init'     => [],
    // 应用开始
    'app_begin'    => [
    ],
    // 模块初始化
    'module_init'  => [],
    // 操作开始执行
    'action_begin' => [
        function(){
            $txt =date('Y-m-d H:i:s').'---IP地址为：'.request()->ip().'访问了 '.request()->controller().'/'.request()->action().' 页面'."\n" ;
            file_put_contents(ROOT_PATH."/public/log/".date('Y-m-d').'log.txt',$txt,FILE_APPEND);
        }
    ],
    // 视图内容过滤
    'view_filter'  => [],
    // 日志写入
    'log_write'    => [],
    // 应用结束
    'app_end'      => [],
];
