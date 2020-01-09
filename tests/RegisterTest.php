<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use tcpadmin\EaseMobSdk\EaseMobSdk;


class RegisterTest extends TestCase
{
    private $username = 'test';
    public function testRegister(){
        EaseMobHelper::initAdminSdk();
        $userModel = EaseMobSdk::userModule();
        $res = $userModel->register($this->username, '123456', 'nickname');
        $this->assertNotFalse($res);
    }

    public function testDel(){
        EaseMobHelper::initAdminSdk();
        $userModel = EaseMobSdk::userModule();
        $res = $userModel->destroy($this->username);
        $this->assertNotFalse($res);
    }
}