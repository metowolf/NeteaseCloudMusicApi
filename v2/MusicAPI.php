<?php
/*!
 * Netease Cloud Music Api
 * https://i-meto.com
 * Version 2.0.0
 *
 * Copyright 2016, METO
 * Released under the MIT license
 */

// RSA Algorithm required
require 'BigInteger.php';

class MusicAPI{
    // General
    protected $_modulus='00e0b509f6259df8642dbc35662901477df22677ec152b5ff68ace615bb7b725152b3ab17a876aea8a5aa76d2e417629ec4ee341f56135fccf695280104e0312ecbda92557c93870114af6c9d05c4f7f0c3685b7a46bee255932575cce10b424d813cfe4875d3e82047b97ddef52741d546b8e289dc6935b3ece0462db0a22b8e7';
    protected $_nonce='0CoJUm6Qyw8W8jud';
    protected $_pubKey='010001';
    protected $_vi='0102030405060708';
    protected $_userAgent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2774.3 Safari/537.36';
    protected $_cookie='appver=2.0.2';
    protected $_secretKey;
    
    public function __construct(){
        $this->_secretKey=$this->createSecretKey(16);
    }

    protected function createSecretKey($length){
    	$str='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $r='';
        for($i=0;$i<$length;$i++){
            $r.=$str[rand(0,strlen($str)-1)];
        }
        return $r;
    }

    protected function prepare($data){
        $data['params']=$this->aes_encode($data['params'],$this->_nonce);
        $data['params']=$this->aes_encode($data['params'],$this->_secretKey);
        $data['encSecKey']=$this->rsa_encode($this->_secretKey);
        return $data;
    }

    protected function aes_encode($secretData,$secret){
        return openssl_encrypt($secretData,'aes-128-cbc',$secret,false,$this->_vi);
    }

    protected function rsa_encode($text){
    	$rtext=strrev(utf8_encode($text));
    	$keytext=$this->bchexdec($this->strToHex($rtext));
        $a=new Math_BigInteger($keytext);
        $b=new Math_BigInteger($this->bchexdec($this->_pubKey));
        $c=new Math_BigInteger($this->bchexdec($this->_modulus));
        $key=$a->modPow($b, $c)->toHex();
        return str_pad($key,256,'0',STR_PAD_LEFT);
    }

    protected function bchexdec($hex){
        $dec=0;
        $len=strlen($hex);
        for($i=0;$i<$len;$i++) {
            $dec=bcadd($dec,bcmul(strval(hexdec($hex[$i])),bcpow('16',strval($len-$i-1))));
        }
        return $dec;
    }
    
    protected function strToHex($str){
        $hex='';
        for($i=0;$i<strlen($str);$i++){
            $hex.=dechex(ord($str[$i]));
        }
        return $hex;
    }

    protected function curl($url,$data=null){
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        if($data){
            if(is_array($data))$data=http_build_query($data);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
            curl_setopt($curl,CURLOPT_POST,1);
        }
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl,CURLOPT_REFERER,'http://music.163.com/');
        curl_setopt($curl,CURLOPT_COOKIE,$this->_cookie);
        curl_setopt($curl,CURLOPT_USERAGENT,$this->_userAgent);
        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function search($s,$type=1,$limit=30,$offset=0){
        $url='http://music.163.com/weapi/cloudsearch/get/web?csrf_token=';
        $data=array(
            'params'=>'{"s":"'.$s.'","type":"'.$type.'","limit":"'.$limit.'","offset":"'.$offset.'","csrf_token":""}',
        );
        return $this->curl($url,$this->prepare($data));
    }

    public function albums($album_id){
        $url='http://music.163.com/weapi/album/'.$album_id;
        $data=array(
            'params'=>'{
                "csrf_token":""
            }',
        );
        return $this->curl($url,$this->prepare($data));
    }

    public function detail($song_id){
        $url='http://music.163.com/weapi/song/detail';
        if(is_array($song_id))$s='["'.implode('","',$song_id).'"]';
        else $s='["'.$song_id.'"]';
        $data=array(
            'params'=>'{
                "ids":'.$s.',
                "csrf_token":""
            }',
        );
        return $this->curl($url,$this->prepare($data));
    }
    
    public function url($song_id){
        $url='http://music.163.com/weapi/song/enhance/player/url?csrf_token=';
        if(is_array($song_id))$s='["'.implode('","',$song_id).'"]';
        else $s='["'.$song_id.'"]';
        $data=array(
            'params'=>'{
                "ids":'.$s.',
                "br":"320000",
                "csrf_token":""
            }',
        );
        return $this->curl($url,$this->prepare($data));
    }

    public function playlist($playlist_id){
        $url='http://music.163.com/weapi/playlist/detail';
        $data=array(
            'params'=>'{
                "id":"'.$playlist_id.'",
                "csrf_token":""
            }',
        );
        return $this->curl($url,$this->prepare($data));
    }

    // old
    public function lyric($song_id){
        $url='http://music.163.com/api/song/lyric';
        $data='os=pc&id='.$song_id.'&lv=-1&kv=-1&tv=-1';
        return $this->curl($url,$data);
    }

    // old
    public function mv($mv_id){
        $url='http://music.163.com/api/mv/detail/?id='.$mv_id.'&type=mp4';
        return $this->curl($url);
    }

    public function id2url($id){
        if($id==null)return null;
        $byte1[]=$this->Str2Arr('3go8&$8*3*3h0k(2)2');
        $byte2[]=$this->Str2Arr($id);
        $magic=$byte1[0];
        $song_id=$byte2[0];
        for($i=0;$i<count($song_id);$i++){
            $song_id[$i]=$song_id[$i]^$magic[$i%count($magic)];
        }
        $result=base64_encode(md5($this->Arr2Str($song_id),1));
        $result=str_replace('/','_',$result);
        $result=str_replace('+','-',$result);
        return $result;
    }

    protected function Str2Arr($string){
        $bytes=[];
        for($i=0;$i<strlen($string);$i++){
            $bytes[]=ord($string[$i]);
        }
        return $bytes;
    }
    protected function Arr2Str($bytes){
        $str='';
        for($i=0;$i<count($bytes);$i++){
            $str.=chr($bytes[$i]);
        }
        return $str;
    }
}