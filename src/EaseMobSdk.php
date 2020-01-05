<?php
namespace tcpadmin\EaseMobSdk;

class EaseMobSdk{
    private static $instanceCore;

    private static $instanceUser;

    private static $instanceMessage;

    /**
     * @param $config
     * @param string $label
     * @return EaseMobCore
     */
    public static function init($config, $label='default'){
        $tmp = new EaseMobCore($config);
        self::$instanceCore[$label] = $tmp;
        return $tmp;
    }

    /**
     * @param string $label
     * @return EaseMobCore
     */
    public static function core($label='default'){
        if(empty(self::$instanceCore[$label])){
            return null;
        }
        return self::$instanceCore[$label];
    }

    /**
     * @param string $label
     * @return EaseMobUser
     */
    public static function userModule($label='default'){
        if(empty(self::$instanceUser[$label])){
            self::$instanceUser[$label] = new EaseMobUser(self::core($label));
        }
        return self::$instanceUser[$label];
    }

    /**
     * @param string $label
     * @return EaseMobMessage
     */
    public static function messageModule($label){
        if(empty(self::$instanceMessage[$label])){
            self::$instanceMessage[$label] = new EaseMobMessage(self::core($label));
        }
        return self::$instanceMessage[$label];
    }
}