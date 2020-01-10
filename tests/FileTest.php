<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use tcpadmin\EaseMobSdk\EaseMobSdk;

class FileTest extends TestCase
{
    public function testUpload(){
        EaseMobHelper::initAdminSdk();
        $msgModule = EaseMobSdk::fileModule();
        $filePath = __DIR__.'/test.jpg';
        $res = $msgModule->upload($filePath);
        $this->assertNotFalse($res);
    }
}