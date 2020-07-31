<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use App\Model\GoodsModel;
class TestController extends Controller
{
    ///111
    public function getWxToken(){
        $appid="wx1f21d2a459d9c0bb";
        $secret="b6be8724084245c2ff8b9011bbfec441";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $content=file_get_contents($url);
        echo $content;
    }
    ///222
    public function getWxToken2(){
        $appid="wx1f21d2a459d9c0bb";
        $secret="b6be8724084245c2ff8b9011bbfec441";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        // 创建一个新cURL资源
        $ch = curl_init();

        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        // 抓取URL并把它传递给浏览器
        $response=curl_exec($ch);

        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);
        echo $response;
    }
    ///333
    public function getWxToken3(){
        $appid="wx1f21d2a459d9c0bb";
        $secret="b6be8724084245c2ff8b9011bbfec441";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $client=new Client();
        $response=$client->request('GET',$url);
        $data=$response->getBody();
        echo $data;
    }
    ///api
    public function getAccessToken(){
        $token=Str::random(32);
        $data=[
            'token'=>$token,
            'expire_in'=>7200
        ];
        echo json_encode($data);
    }
    ////////
    public function userInfo(){
        echo "userInfo";
    }
    ////////
    public function test2(){
        $url='http://api.1911.com/test2';
        $response=file_get_contents($url);
        var_dump($response);
    }
    //接口登录
    public function login(){
        $email=request()->post("email");
        $pwd=request()->post("pwd");
        print_r($_POST);
    }
    //商品接口
    public function goods(){
        $goods_id=\request()->get("id");
        $key="h:goods_info:".$goods_id;
        //先判断缓存
        $info=Redis::hgetAll($key);
        if(empty($info)){
            $g=GoodsModel::select("goods_id","goods_sn","goods_name")->find($goods_id);
            print_r($g->toArray());
            //缓存到redis
            $goods_info=$g->toArray();
            Redis::hMset($key,$goods_info);
            echo "无缓存";
            print_r($info);
        }else{
            echo "缓存";
            print_r($info);
        }
        //增加访问次数
        Redis::hincrby($key,'view_count',1);
    }
    ////
    public function test1(){

    }
    ///
    public function test3(){
        return redirect("https://www.baidu.com/");
    }
    /////////////对称
    //加密
    public function enc1(){
        $data="zhangfei";       //原始数据
        $method="AES-256-CBC";      //加密算法
        $key="001";     //加密密钥
        $iv="1111222233334444";     //初始化$iv，cbc加密算法使用
        //加密
        $enc_date=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        $b64_str=base64_encode($enc_date);
        $url='http://api.1911.com/dec2?data='.urlencode($b64_str);
        $response=file_get_contents($url);
        var_dump($response);
        //解密
//        $dec_data=openssl_decrypt($enc_date,$method,$key,OPENSSL_RAW_DATA,$iv);
//        echo $dec_data;
    }
    //解密
    public function dec1(){
        $method="AES-256-CBC";      //加密算法
        $key="001";     //加密密钥
        $iv="1111222233334444";     //初始化$iv，cbc加密算法使用
        $enc_date=\request()->post("data");
        $dec_data=openssl_decrypt($enc_date,$method,$key,OPENSSL_RAW_DATA,$iv);
        var_dump($dec_data);
    }
    ///////////////非对称
    //加密
    public function rsa1(){
        $data="BABA";
        $connect=file_get_contents(storage_path('keys/www_pub.key'));
        $pub_key=openssl_get_publickey($connect);
        openssl_public_encrypt($data,$enc_data,$pub_key);
        $b64_str=base64_encode($enc_data);
        $url='http://api.1911.com/rsa2?data='.urlencode($b64_str);
        $response=file_get_contents($url);
        var_dump($response);
    }
    //解密
    public function rsa21(){
        $enc_date=base64_decode(request()->get("data"));
        $connect=file_get_contents(storage_path('keys/api_priv.key'));
        $priv_key=openssl_get_privatekey($connect);
        openssl_private_decrypt($enc_date,$dec_data,$priv_key);
        echo $dec_data;
    }
    ///////签名测试
    public function sign1(){
        $data="张非非";
        $key="111";
        $sign_str=md5($data.$key);
        $url="http://api.1911.com/sign2?data=".$data."&sign=".$sign_str;
        $response=file_get_contents($url);
        echo $response;
    }
    //////header传参
    public function header1(){
        $url="http://api.1911.com/header1";
        $uid="123321";
        $token=Str::random(16);
        //header传参
        $headers=[
            "uid:".$uid,
            "token:".$token
        ];
        //curl
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);   //header头部传参
        curl_exec($ch);
        curl_close($ch);
    }
}
