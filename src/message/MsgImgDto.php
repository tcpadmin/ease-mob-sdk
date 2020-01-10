<?php
namespace tcpadmin\EaseMobSdk\message;

/**
 * 图片类型消息
 * Class MsgTextDto
 * @package tcpadmin\EaseMobSdk\message
 */
class MsgImgDto extends AbstractMsg{

    /**
     * @var string
     */
    public $msg;

    public function __construct($imgUrl, ...$target){
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