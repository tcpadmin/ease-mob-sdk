<?php
namespace tcpadmin\EaseMobSdk;

use Curl\Curl;

class EaseMobCore
{
    const LOG_DEBUG = 1;
    const LOG_WARN = 2;
    const LOG_ERROR = 3;
    const LOG_NONE = 4;

    private $curl;
    private $host = 'http://a1.easemob.com';
    private $orgName = '';
    private $appName = '';
    private $clientId = '';
    private $clientSecret = '';
    private $logPath = '';
    private $logLevel = self::LOG_ERROR;

    private $token;

    public function __construct($config=[]){
        foreach(['host','orgName', 'appName', 'clientId', 'clientSecret'] as $k){
            if(!isset($config[$k])) continue;
            $this->$k = $config[$k];
        }

        $this->curl = new Curl();
        if(!empty($config['proxyHost']) && !empty($config['proxyPort'])){
            $this->curl->setProxy($config['proxyHost'], $config['proxyPort']);
        }
    }

    public function getToken(){
        return $this->token;
    }

    public function setToken($token){
        $this->token = $token;
        return $this;
    }

    public function getCurl(){
        return $this->curl;
    }

    public function adminRequest($method, $url, $data=[]){
        if(!$this->token){
            $this->log(self::LOG_ERROR, 'Empty Token!');
            return false;
        }
        $this->curl->setHeader('Authorization', "Bearer {$this->token}");
        return $this->request($method, $url, $data);
    }

    public function request($method, $url, $data=[]){
        if(strpos($url,'/')!==0){
            $url = "{$this->host}/{$this->orgName}/{$this->appName}/$url";
        }
        $curl = $this->curl;
        switch(strtoupper($method)){
            case 'POST':
                $curl->setHeader('Content-Type', 'application/json');
                $curl->post($url, $data);
                break;
            case 'GET':
                $curl->get($url);
                break;
            case 'DELETE':
                $curl->delete($url);
                break;
            default:
                return false;
        }
        if($curl->error){
            $this->log(self::LOG_ERROR, 'Request Exception',[
                'url'=>$url, 'data'=>$data, 'code'=>$curl->errorCode, 'msg'=>$curl->errorMessage, 'res'=>$curl->getRawResponse(),
            ]);
            return false;
        }
        $res = json_decode($curl->getRawResponse(), true);
        if(!empty($res['error'])){
            $this->log(self::LOG_ERROR, 'Request Fail',['url'=>$url, 'data'=>$data, 'res'=>$curl->getRawResponse()]);
            return false;
        }
        $this->log(self::LOG_DEBUG, 'Request', ['url'=>$url, 'data'=>$data, 'res'=>$curl->getRawResponse()]);
        return $res;
    }

    /**
     * 获取token
     * @link http://docs-im.easemob.com/im/server/ready/user#%E8%8E%B7%E5%8F%96%E7%AE%A1%E7%90%86%E5%91%98%E6%9D%83%E9%99%90
     * @return bool|mixed
     */
    public function fetchToken(){
        $tokenRes = $this->request('post','token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);
        if($tokenRes){
            $this->token = $tokenRes['accessToken'];
        }
        return $tokenRes;
    }

    private function log($level, $str, $context=[]){
        if($this->logLevel > $level || !$this->logPath) return;
        $levelMark = [
            self::LOG_DEBUG => 'DEBUG',
            self::LOG_WARN => 'WARN',
            self::LOG_ERROR => 'ERROR',
        ];
        $logStr = sprintf("%s|%s[%s]%s\n", date('Y-m-d H:i:s'), $levelMark[$level], $str, json_encode($context));
        file_put_contents($this->logPath, $logStr, FILE_APPEND);
    }
}