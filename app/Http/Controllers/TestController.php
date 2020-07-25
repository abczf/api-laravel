<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class TestController extends Controller
{
    //
    public function test1(){
        $url='http://www.1911.com/user/info';
        $response=file_get_contents($url);
        var_dump($response);
    }
    //
    public function test2(){
        echo "test2";
    }

    //////对称加密
    //解密
    public function dec2(){
        $enc_date=base64_decode(request()->get("data"));
        $method="AES-256-CBC";      //加密算法
        $key="001";     //加密密钥
        $iv='1111222233334444';     //初始化$iv，cbc加密算法使用
        $dec_data=openssl_decrypt($enc_date,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo $dec_data;
    }
    //////非对称加密
    //解密
    public function rsa2(){
        $enc_date=base64_decode(request()->get("data"));
        $connect=file_get_contents(storage_path('keys/www_priv.key'));
        $priv_key=openssl_get_privatekey($connect);
        openssl_private_decrypt($enc_date,$dec_data,$priv_key);
        echo $dec_data;
    }
    //加密
    public function rsa11(){
        $data="吧嗒吧嗒";
        $connect=file_get_contents(storage_path('keys/api_pub.key'));
        $pub_key=openssl_get_publickey($connect);
        openssl_public_encrypt($data,$enc_data,$pub_key);
        $b64_str=base64_encode($enc_data);
        $url='http://www.1911.com/rsa21?data='.urlencode($b64_str);
        $response=file_get_contents($url);
        var_dump($response);
    }
    ///签名测试
    public function sign2(){
        //签名key
        $key="111";
        //接收数据
        $data=\request()->get("data");
        $sign=\request()->get("sign");
        //计算签名
        $sign_str2=md5($data.$key);
        if($sign_str2==$sign){
            echo "验签通过";
        }else{
            echo "验签失败";
        }
    }
}




