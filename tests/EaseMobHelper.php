<?php
namespace Test;

use tcpadmin\EaseMobSdk\EaseMobSdk;

class EaseMobHelper{
    private static $init = false;
    private static $token;
    public static function initSdk(){
        if(!self::$init){
            $config = include TEST_CONFIG_PATH;
            return EaseMobSdk::init($config);
        }
        return EaseMobSdk::core();
    }

    public static function initAdminSdk(){
        $token = self::$token ?? self::getToken();
        self::initSdk()->setToken($token);
    }

    private static function getToken(){
        $tokenFile = TEST_TOKEN_PATH;
        if(!file_exists($tokenFile)){
            $token = self::initSdk()->fetchToken();
            if($token && $token['access_token']){
                $token['expire_in'] = time() + $token['expire_in'];
                file_put_contents($tokenFile, json_encode($token));
            }
        }else{
            $token = file_get_contents($tokenFile);
            $token = json_decode($token, true);
            if(!$token || $token['expire_in']>time()){
                unlink($tokenFile);
                return self::getToken();
            }
        }
        return $token['access_token'];
    }
}