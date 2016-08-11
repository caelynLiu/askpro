<?php

namespace App\Http\Controllers;

use Log;

class WechatController extends Controller
{

    /**
     * 获取 可用的消息类型
     * @return [array]
     */
    protected static function getWechatMsgType(){
        return [
            'event',// 事件类型
        ];
    }

    /**
     * 处理微信的请求消息
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.');

        $wechat = app('wechat');

        $wechat->server->setMessageHandler(

            function($message){

                $canUseMsgType   = self::getWechatMsgType();
                
                $msgType         = $message->MsgType; // 交互的类型

                $msgType         = strtolower($msgType);
                
                $class           = '\App\Http\Logics\Weixin\MsgType\\'.ucfirst($msgType).'Logic'; // 交互类型处理Logic

                if(!in_array(strtolower($msgType), $canUseMsgType) || !class_exists($class)){

                    $class   = '\App\Http\Logics\Weixin\MsgType\AnyInvalidLogic';

                }

                Log::info('run class:'.$class);

                $obj = new $class;
                
                return $obj->handle($message);
            }

        );

        Log::info('return response.');

        return $wechat->server->serve();
    }
}