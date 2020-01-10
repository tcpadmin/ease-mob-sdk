<?php
namespace tcpadmin\EaseMobSdk;

class EaseMobSdk{
    private static $instanceCore;

    private static $instanceUser;

    private static $instanceMessage;

    private static $instanceFile;

    /**
     * 如果已存在就忽略
     * @param $config
     * @param string $label
     * @return EaseMobCore
     */
    public static function init($config, $label='default'){
        if(empty(self::$instanceCore[$label])){
            return self::initForce($config, $label);
        }
        return self::$instanceCore[$label];
    }

    /**
     * @param $config
     * @param string $label
     * @return EaseMobCore
     */
    public static function initForce($config, $label='default'){
        $tmp = new EaseMobCore($config);
        self::$instanceCore[$label] = $tmp;
        return $tmp;
    }

    /**
     * @param string $label
     * @return EaseMobCore
     * @throws \Exception
     */
    public static function core($label='default'){
        if(empty(self::$instanceCore[$label])){
            throw new \Exception('Instance has not been initialized');
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
    public static function messageModule($label='default'){
        if(empty(self::$instanceMessage[$label])){
            self::$instanceMessage[$label] = new EaseMobMessage(self::core($label));
        }
        return self::$instanceMessage[$label];
    }

    /**
     * @param string $label
     * @return EaseMobFile
     */
    public static function fileModule($label='default'){
        if(empty(self::$instanceFile[$label])){
            self::$instanceFile[$label] = new EaseMobFile(self::core($label));
        }
        return self::$instanceFile[$label];
    }
}