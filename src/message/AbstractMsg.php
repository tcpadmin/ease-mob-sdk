<?php
namespace tcpadmin\EaseMobSdk\message;

abstract class AbstractMsg{
    /**
     * 给用户发消息
     */
    const targetTypeUsers = 'users';
    /**
     * 给群发消息
     */
    const targetTypeGroups = 'chatgroups';
    /**
     * 给聊天室发消息
     */
    const targetTypeRooms = 'chatrooms';

    const msgTypeText = 'txt';
    const msgTypeImg = 'img';
    const msgTypeLoc = 'loc';
    const msgTypeAudio = 'audio';
    const msgTypeVideo = 'video';
    const msgTypeFile = 'file';

    /**
     * @var string 目标类型
     */
    private $targetType = self::targetTypeUsers;

    public function setTargetType($targetType){
        if(!in_array($targetType, [self::targetTypeUsers, self::targetTypeGroups, self::targetTypeRooms])){
            throw new \Exception("error TargetType");
        }
        $this->targetType = $targetType;
        return $this;
    }

    public function getTargetType(){
        return $this->targetType;
    }

    /**
     * 即使1个用户也要用数组
     * 最好不大于20个元素
     * 用户的元素时username 群组的元素时groupId
     * @var array 目标
     */
    private $targetListMap = [];

    /**
     * @var string username
     */
    public $from = 'admin';

    public abstract function getMsgType();

    protected abstract function getMsgData();

    public function getBody(){
        return [
            'target_type' => $this->getTargetType(),
            'target' => $this->getTarget(),
            'from' => $this->from,
            'msg' => $this->getMsgData(),
        ];
    }

    /**
     * 添加收件人
     * @param mixed ...$targets
     * @return $this
     */
    public function addTarget(...$targets){
        foreach($targets as $target){
            $this->targetListMap[$target] = 1;
        }
        return $this;
    }

    /**
     * 重置收件人
     * @param mixed ...$targets
     * @return $this
     */
    public function resetTarget(...$targets){
        $this->targetListMap = [];
        foreach($targets as $target){
            $this->targetListMap[$target] = 1;
        }
        return $this;
    }

    /**
     * 获取收件人
     * @return array
     */
    public function getTarget(){
        return array_keys($this->targetListMap);
    }
}