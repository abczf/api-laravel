<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use App\Model\TokenModel;
use Illuminate\Support\Str;
class IndexController extends Controller
{
    //注册
    public function reg(){
        $user_name=\request()->post("user_name");
        $user_email=\request()->post("user_email");
        $user_pwd=\request()->post("user_pwd");
        $user_pwds=\request()->post("user_pwds");
        //token验证
        $pass=password_hash($user_pwd,PASSWORD_BCRYPT);
        $user_info=[
            'p_name'=>$user_name,
            'p_email'=>$user_email,
            'p_pwd'=>$pass,
            'p_time'=>time()
        ];
        $pid=UserModel::insertGetId($user_info);
        $response=[
            'errno'=>0,
            'msg'=>'ok'
        ];
        return $response;
    }
    //登录
    public function login(){

        $user_name=\request()->post("user_name");
        $user_pwd=\request()->post("user_pwd");
        $u=UserModel::where(['p_name'=>$user_name])->first();
//        var_dump($u);die;
        if($u){
            //验证密码
            if(password_verify($user_pwd,$u->p_pwd)){
                $token=Str::random(32);
                $expire_seconds=3600;
                $data=[
                    'token'=>$token,
                    'uid'=>$u->p_id,
                    'expire_at'=>time()+$expire_seconds
                ];
                //入库
                $tid=TokenModel::insertGetId($data);
                $response=[
                    'errno'=>0,
                    'msg'=>"ok",
                    'data'=>[
                        'token'=>$token,
                        'expire_in'=>$expire_seconds
                    ]
                ];

            }else{
                $response=[
                    'errno'=>50001,
                    'msg'=>"密码错误"
                ];
            }
        }else{
            $response=[
                'errno'=>40001,
                'msg'=>"用户不存在"
            ];
        }
        return $response;
    }
    //个人中心
    public function center(){
        //验证是否有token
        $token=\request()->get("token");
        if(empty($token)){
            $response=[
                "errno"=>40003,
                "msg"=>"未授权"
            ];
            return $response;
        }
        //验证token是否有效
        $t=TokenModel::where(["token"=>$token])->first();
        if(empty($t)){
            $response=[
                "errno"=>40004,
                "msg"=>"token无效"
            ];
            return $response;
        }
        $user_info=UserModel::find($t->uid);
        $response=[
            "errno"=>0,
            "msg"=>"ok",
            "data"=>[
                "user_info"=>$user_info
            ]
        ];
        return $response;
    }
}
