<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use tcpadmin\EaseMobSdk\EaseMobSdk;


class RegisterTest extends TestCase
{
    public function testRegister(){
        $username = 'test';
        $userModel = EaseMobSdk::userModule();
        $res = $userModel->register($username, '123456', 'nickname');

    }
}