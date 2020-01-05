<?php
namespace tcpadmin\EaseMobSdk;

use Curl\Curl;

class EaseMobMessage{
    /**
     * @var EaseMobCore process request
     */
    private $core;

    public function __construct(EaseMobCore $core){
        $this->core = $core;
    }

}