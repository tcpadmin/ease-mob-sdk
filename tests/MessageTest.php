<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use tcpadmin\EaseMobSdk\EaseMobSdk;
use tcpadmin\EaseMobSdk\message\MsgTextDto;

class MessageTest extends TestCase
{
    public function testText(){
        EaseMobHelper::initAdminSdk();
        $user1 = 'yU4AAAACpslO';
        $msg = new MsgTextDto("Hello", $user1);
        $msgModule = EaseMobSdk::messageModule();
        $res = $msgModule->adminSend($msg);
        $this->assertNotFalse($res);
    }

    public function testHistory(){
        EaseMobHelper::initAdminSdk();
        $msgModule = EaseMobSdk::messageModule();
        $msgModule->history(202001);
    }
}