<?php
namespace tcpadmin\EaseMobSdk;

/**
 * 文件相关
 * @link http://docs-im.easemob.com/im/server/basics/fileoperation
 * Class EaseMobUser
 * @package tcpadmin\EaseMobSdk
 */
class EaseMobFile{
    /**
     * @var EaseMobCore process request
     */
    private $core;

    public function __construct(EaseMobCore $core){
        $this->core = $core;
    }

    /**
     * 上传语音 图片
     *
     * @link http://docs-im.easemob.com/im/server/basics/fileoperation#%E6%96%87%E4%BB%B6%E4%B8%8A%E4%BC%A0%E4%B8%8B%E8%BD%BD
     *
     * @param string $filePath
     * @return array
     */
    public function upload($filePath){
        $curl = $this->core->getCurl();
        $curl->setHeader('restrict-access', true);
        $curl->setMaxFilesize(1024*1024*10);//10M
        return $this->core->adminRequest('file', 'chatfiles',[
            'file'=>"@$filePath"
        ]);
    }
}