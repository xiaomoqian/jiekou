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

use think\Route;

Route::get('v1/login','api/v1.login/login');//用户登录
Route::get('v1/regist','api/v1.index/regist');//用户注册
Route::get('v1/reset','api/v1.index/reset');//用户密码重置
Route::get('v1/banner','api/v1.index/banner');//商品首页
Route::get('v1/seckill','api/v1.index/seckill');//商品首页
Route::get('v1/getyourfav','api/v1.index/getyourfav');//猜你喜欢
Route::get('v1/category','api/v1.index/category');//分类列表
Route::get('v1/brand','api/v1.index/brand');//品牌列表
Route::get('v1/productInfo','api/v1.index/productInfo');//商品信息
Route::get('v1/shopcar','api/v1.index/shopcar');//购物车信息
