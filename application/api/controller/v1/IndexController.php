<?php

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use Lcobucci\JWT\Builder;
use think\Db;
use app\common\model\User;



class IndexController extends BaseController
{
    /*
     * 注册
     */
    public function Regist()
    {
        $regist = new User();

        //判断用户名是否存在
        if (!empty(Db::name('user')->where(['username' => request()->post('username')])->select())) {
            return $this->ApiJson(null, false, "用户名已经存在");
        }
        $regist->username=request()->post('username');
        $regist->password_hash=password_hash(request()->post('password_hash'),PASSWORD_DEFAULT);
        if ($regist->save()) {
            $regist = [
                "id" => $regist['id']
            ];
            return $this->ApiJson($regist);
        } else {
            return $this->ApiJson(null, false, "用户注册失败");
        }
    }

    /*
     * 密码重置
     */
    public function Reset($username)
    {
        $re = Db::name('user')->where(['username' => $username])->setField("password_hash", password_hash(123456, PASSWORD_DEFAULT));
//            $result['password_hash']=password_hash(123456,PASSWORD_DEFAULT);
        if ($re) {
            $data = [
                'password' => 123456
            ];
            return $this->ApiJson($data);
        } else {
            return $this->ApiJson(null, false, "重置失败");
        }
    }

    /*
     * 商品显示
     */
    public function Banner()
    {

        $goods = Db::name('goos')->select();
        if ($goods) {
            $result = [];
            foreach ($goods as $good) {
                $result[] = [
                    "id" => $good['id'],
                    "type" => $good['sale'],
                    "adUrl" => $good['logo'],
                    "webUrl" => "",
                    "adkind" => $good['status'],
                ];
            }
            return $this->ApiJson($result);
        } else {
            return $this->ApiJson(null, false, "没有商品");
        }
    }

    /*
     *秒杀商品
     */
    public function Seckill($id)
    {

        $goods = Db::name("goos")->where(['id' => $id])->find();
        if ($goods) {
            $result = [
                "total" => $goods['stock'],
                "rows" => [
                      "allPrice"=>$goods['stock_price'],
                      "pointPrice"=>$goods['shop_price'],
                      "iconUrl"=>$goods['logo'],
                      "timeLeft"=>time()+3600*24-time(),
                      "type"=>$goods['sale'],
                      "productId"=>$goods['id']
                 ]
             ];
           return $this->ApiJson($result);
         } else {
            return $this->ApiJson(null, false, '商品也被抢购一空');
        }
    }
    /*
     * 猜你喜欢
     */
    public function GetYourFav()
    {
        $goods = Db::name("goos")->limit(4)->select();
        if ($goods) {
            $result=[];
            foreach ($goods as $good){
                $result[]= [
                    "total" => $good['stock'],
                    "rows" => [
                       "price"=>$good['shop_price'],
                       "name"=>$good['name'],
                       "iconUrl"=>$good['logo'],
                       "productId"=>$good['id']
                    ]
                ];
            }
            return $this->ApiJson($result);
        } else {
            return $this->ApiJson(null, false, '商品也被抢购一空');
        }
    }


    /*
     * 商品搜索
     */
    public function SearchProduct()
    {
        
    }



    /*
     *分类列表
     */
    public function CateGory()
    {
        $cates=Db::name('goods_category')->where(['parent_id'=>0])->select();
        $realut=[];
          foreach ($cates as $cate){
              $gorys=Db::name('goods_category')->where(['parent_id'=>$cate['id']])->select();
                $realut[]=[
                    "Fid"=>$cate['id'],
                    "bannerUrl"=>"",
                    'name'=>$cate['name']
                ];
                foreach ($gorys as $gory){
                    $gorys1=Db::name('goods_category')->where(['parent_id'=>$gory['id']])->select();
                    $realut[]=[
                        "Zid"=>$gory['id'],
                        "bannerUrl"=>"",
                        'name'=>$gory['name']
                    ];
                    foreach ($gorys1 as $value){
                        $realut[]=[
                            "ZRid"=>$value['id'],
                            "bannerUrl"=>"",
                            'name'=>$value['name']
                        ];
                    }

                }
          }
          return $this->ApiJson($realut);
    }
    /*
     * 品牌列表
     */
    public function Brand($id)
    {
        $brands=Db::name('brand')->where(['goods_category_id'=>$id])->select();
        if($brands){
            $realut=[];
            foreach ($brands as $brand){
                  $realut[]=[
                      "id"=>$brand['id'],
                      "name"=>$brand['name']
                  ];
            }
            return $this->ApiJson($realut);
        }else{
            return $this->ApiJson(null, false, '分类没有商品');
        }
    }
    /*
     * 商品信息
     */
    public function ProductInfo($id){
        $goods=Db::name("goods_details")->where(['goods_id'=>$id])->find();
        $imgs=Db::name("goods_img")->where(['goobs_id'=>$id])->select();
        $goos=Db::name('goos')->where(['id'=>$id])->find();
        $gooss=Db::name('goos')->where('id!='.$id)->select();
        $realuts["id"]=$id;
        foreach ($imgs as $img){
            $realuts["imgUrls"][]=$img['img'];
        }
        $realuts['price']=$goos['shop_price'];
        $realuts['ifSaleOneself']="是";
        $realuts['stockCount']=$goos['stock'];
        $realuts['commentCount']=$goods['commentCount'];
        $realuts['typeList']="";
        $realuts['favcomRate']="50%";
        foreach ($gooss as $goos){
            $realuts['recomProduct'][]=$goos['name'];
        }
     return $this->ApiJson($realuts);
    }
    /*
     * 购物车信息
     */
    public function ShopCar($id)
    {
        $carts=Db::name('cart')->where(['user_id'=>$id])->select();
        foreach ($carts as $cart){
            $goos=Db::name('goos')->where(['id'=>$cart['goods_id']])->find();
            $realuts=[
                "id"=>$cart['id'],
                "buyCount"=>$cart['num'],
                "storeName"=>$goos['name'],
                "ppeice"=>$goos['shop_price'],
                "pimageUrl"=>$goos['logo'],
                "pid"=>$goos['id'],
                'stockCount'=>$goos['stock'],
                'storeId'=>"",
                "pversion"=>""
            ];
        }
       return $this->ApiJson($realuts);
    }
}
