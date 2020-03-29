<?php
namespace tcpadmin\EaseMobSdk;

class EaseMobUser{
    /**
     * @var EaseMobCore process request
     */
    private $core;

    public function __construct(EaseMobCore $core){
        $this->core = $core;
    }

    /**
     * 注册单个用户(授权)
     *
     * @link http://docs-im.easemob.com/im/server/ready/user#%E6%B3%A8%E5%86%8C%E5%8D%95%E4%B8%AA%E7%94%A8%E6%88%B7_%E6%8E%88%E6%9D%83
     *
     * @param string $username
     * @param string $password
     * @param string $nickname
     *
     * @return array
     */
    public function register($username, $password, $nickname=''){
        return $this->core->adminRequest('post', 'users', [
            'username' => $username,
            'password' => $password,
            'nickname' => $nickname,
        ]);
    }

    /**
     * 删除单个用户
     *
     * @link http://docs-im.easemob.com/im/server/ready/user#%E5%88%A0%E9%99%A4%E5%8D%95%E4%B8%AA%E7%94%A8%E6%88%B7
     *
     * @param string $username
     *
     * @return array
     */
    public function destroy($username){
        return $this->core->adminRequest('delete', "users/$username");
    }

    /**
     * 获取单个用户信息
     * @link http://docs-im.easemob.com/im/server/ready/user#%E8%8E%B7%E5%8F%96%E5%8D%95%E4%B8%AA%E7%94%A8%E6%88%B7
     * @param $username
     * @return bool|mixed
     */
    public function user($username){
        return $this->core->adminRequest('get', "users/$username");
    }
}