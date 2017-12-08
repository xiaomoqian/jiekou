<?php

namespace app\api\controller;
use think\Controller;
use think\response\Json;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Keychain;
class baseController extends Controller
{
    protected $user;
    public function _initialize()
    {
        parent::_initialize();
        $token=request()->param("token");
            $result=[
                "result"=>null,
                "success"=>"令牌无效",
                "errorMsg"=>false,
            ];
            if(!$token){
                exit(json_encode($result));
            }
            $token = (new Parser())->parse((string) $token);
            $data = new ValidationData();
            $data->setIssuer('http://www.api.com');
            if($token->validate($data)==false){
                exit(json_encode($result));
            }
            $this->user=$token->getClaim('user_id');
            $keychain = new Keychain();
            $signer  =  new  Sha256();
            $token = (new Builder())->setIssuer('http://www.api.com')
                ->setExpiration(time() + 3600)
                ->set('uid', $this->user)
                ->sign($signer, 'xiaowen')
//                ->sign($signer,  $keychain->getPrivateKey('file://{path to your private key}'))
                ->getToken();
        if(!$token->verify($signer, 'xiaowen')){
            exit(json_encode($result));
        }
    }

   public function ApiJson($data,$success='true',$msg="")
    {
        $result=[
            "result"=>$data,//返回实际数据
            "success"=>$success,//失败是返回错误信息
            "errorMsg"=>$msg,//false代表服务器返回数据失败，true代表成功

        ];
        return Json($result);
    }
}
