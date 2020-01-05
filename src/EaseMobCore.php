<?php
namespace tcpadmin\EaseMobSdk;

use Curl\Curl;

class EaseMobCore
{
    private $curl;
    private $host = 'http://a1.easemob.com';
    private $orgName = '';
    private $appName = '';
    private $clientId = '';
    private $clientSecret = '';

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

    public function setToken($token){
        $this->token = $token;
        return $this;
    }

    public function getCurl(){
        return $this->curl;
    }

    public function adminRequest($method, $url, $data=[]){
        if(!$this->token){
            $this->log('Empty Token!');
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
            $this->log('Request Exception',[
                'url'=>$url, 'data'=>$data, 'code'=>$curl->errorCode, 'msg'=>$curl->errorMessage, 'res'=>$curl->getRawResponse(),
            ]);
            return false;
        }
        $res = json_decode($curl->getRawResponse(), true);
        if(!empty($res['error'])){
            $this->log('Request Fail',['url'=>$url, 'data'=>$data, 'res'=>$curl->getRawResponse()]);
            return false;
        }
        return $res;
    }

    /*private function getTokenFromCache(){
        return false;
    }
    private function cacheToken($token){
        return false;
    }
    private function getLock(){
        return true;
    }
    private function releaseLock(){
        return true;
    }*/
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

    /*public function getToken($times=0){
        if($this->token)return $this->token;

        $token = $this->getTokenFromCache();
        if($token) return $token;

        if($this->getLock()){
            $token = $this->getTokenNoCache();
            $this->releaseLock();
            return $token;
        }
        if($times < 3){
            //sleep 100ms
            usleep(100000);
            return $this->getToken($times+1);
        }
        return false;
    }*/

    private function log($str, $context=[]){
        var_dump($str, $context);
    }
}