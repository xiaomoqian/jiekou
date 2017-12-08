<?php
/**
 * Created by PhpStorm.
 * User: SAMSUNG
 * Date: 2017/11/28
 * Time: 14:17
 */

namespace app\api\controller\v1;


use Lcobucci\JWT\Builder;
use think\Controller;
use think\Db;

class LoginController extends Controller
{
    /**
     * @api {get} /login/login login
     * @apiVersion 1.0.0
     * @apiName login
     * @apiGroup login
     *
     * @apiDescription login
     *
     * @apiParam {string} username 用户名
     * @apiParam {strimg} password_hash 密码
     *
     */
//@apiParam {strimg} token 令牌
    public function Login($username, $password_hash)
    {
        $user = Db::name('user')->where(['username' => $username])->find();
        if ($user) {
            if (password_verify($password_hash, $user['password_hash'])) {
                $token=(new  Builder())->setIssuer('http://www.api.com')
                    ->setExpiration(time() + 3600)
                    ->set('user_id', $user['id'])
                    ->getToken();
                $result = [
                    "username" => $user['username'],
                    "userIcon" => "",
                    "waitPayCount" => 10,
                    "waitReceiveCount" => 20,
                    "userLevel" => 5,
                    'token'=>(string)$token
                ];
                return Api_json($result);
            } else {
                return Api_json(null, false, '密码错误');
            }
        } else {
            return Api_json(null, false, '用户名不存在');
        }
    }

}