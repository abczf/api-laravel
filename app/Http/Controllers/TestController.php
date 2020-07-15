<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        
    }
}
