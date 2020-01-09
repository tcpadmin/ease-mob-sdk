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
}