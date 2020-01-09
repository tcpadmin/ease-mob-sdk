<?php
namespace tcpadmin\EaseMobSdk\message;

class MsgTextDto extends AbstractMsg{

    /**
     * @var string
     */
    public $msg;

    public function __construct($msg='', $target=''){
        $this->msg = $msg;
    }

    function getMsgType(){
        return AbstractMsg::msgTypeText;
    }
}