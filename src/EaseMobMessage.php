<?php
namespace tcpadmin\EaseMobSdk;

use tcpadmin\EaseMobSdk\message\AbstractMsg;

class EaseMobMessage{
    /**
     * @var EaseMobCore process request
     */
    private $core;

    public function __construct(EaseMobCore $core){
        $this->core = $core;
    }

    public function adminSend(AbstractMsg $msg){
        return $this->core->adminRequest('post', 'messages', $msg->getBody());
    }

    /**
     * @link http://docs-im.easemob.com/im/server/basics/chatrecord#%E8%8E%B7%E5%8F%96%E5%8E%86%E5%8F%B2%E6%B6%88%E6%81%AF%E6%96%87%E4%BB%B6
     * @param $time 2019013118
     * @return bool|mixed
     */
    public function history($time){
        return $this->core->adminRequest('get', "chatmessages/$time");
    }
}