<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getWxToken(){
        $appid="wx1f21d2a459d9c0bb";
        $secret="b6be8724084245c2ff8b9011bbfec441";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $content=file_get_contents($url);
        echo $content;
    }
}
