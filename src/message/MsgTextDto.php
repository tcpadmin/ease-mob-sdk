<?php
namespace tcpadmin\EaseMobSdk\message;

/**
 * 纯文本类型消息
 * Class MsgTextDto
 * @package tcpadmin\EaseMobSdk\message
 */
class MsgTextDto extends AbstractMsg{

    /**
     * @var string
     */
    public $msg;

    public function __construct($msg, ...$target){
        $this->msg = $msg;
        if($target) $this->addTarget(...$target);
    }

    public function getMsgType(){
        return AbstractMsg::msgTypeText;
    }

    protected function getMsgData(){
        return [
            'type' => $this->getMsgType(),
            'msg' => $this->msg,
        ];
    }
}