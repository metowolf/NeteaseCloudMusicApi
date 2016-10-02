<?php
/*!
 * Netease Cloud Music Api
 * https://i-meto.com
 * Version 1 stop support
 *
 * Copyright 2016, METO
 * Released under the MIT license
 */

class NeteaseMusicAPI{


    // General
    protected $_USERAGENT='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.157 Safari/537.36';
    protected $_COOKIE='os=pc; osver=Microsoft-Windows-10-Professional-build-10586-64bit; appver=2.0.2; channel=netease; __remember_me=true';
    protected $_REFERER='http://music.163.com/';

    // CURL
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
        curl_setopt($curl,CURLOPT_REFERER,$this->_REFERER);
        curl_setopt($curl,CURLOPT_COOKIE,$this->_COOKIE);
        curl_setopt($curl,CURLOPT_USERAGENT,$this->_USERAGENT);
        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    // main function
    public function search($s=null,$limit=30,$offset=0,$type=1){
        $url='http://music.163.com/api/search/pc';
        $data=array(
            's'=>$s,
            'type'=>$type,
            'limit'=>$limit,
            'total'=>'true',
            'offset'=>$offset,
        );
        return $this->curl($url,$data);
    }

    public function artist($id){
        $url='http://music.163.com/api/artist/'.$id;
        return $this->curl($url);
    }

    public function album($album_id){
        $url='http://music.163.com/api/album/'.$album_id;
        return $this->curl($url);
    }

    public function detail($song_id){
        $url='http://music.163.com/api/song/detail';
        $data='id='.$song_id.'&ids=%5B'.$song_id.'%5D';
        return $this->curl($url,$data);
    }

    public function playlist($playlist_id){
        $url='http://music.163.com/api/playlist/detail?id='.$playlist_id.'&updateTime=-1';
        return $this->curl($url);
    }

    public function lyric($song_id){
        $url='http://music.163.com/api/song/lyric';
        $data=array(
            'id'=>$song_id,
            'os'=>'pc',
            'lv'=>-1,
            'kv'=>-1,
            'tv'=>-1,
            'csrf_token'=>'',
        );
        return $this->curl($url,$data);
    }

    public function mv($mv_id){
        $url='http://music.163.com/api/mv/detail/?id='.$mv_id.'&type=mp4';
        return $this->curl($url);
    }

    /* static url encrypt, use for pic*/
    public function Id2Url($id){
        $byte1[]=$this->Str2Arr('3go8&$8*3*3h0k(2)2');
        $byte2[]=$this->Str2Arr($id);
        $magic=$byte1[0];
        $song_id=$byte2[0];
        for($i=0;$i<count($song_id);$i++)$song_id[$i]=$song_id[$i]^$magic[$i%count($magic)];
        $result=base64_encode(md5($this->Arr2Str($song_id),1));
        $result=str_replace('/','_',$result);
        $result=str_replace('+','-',$result);
        return $result;
    }
    protected function Str2Arr($string){
        $bytes=array();
        for($i=0;$i<strlen($string);$i++)$bytes[]=ord($string[$i]);
        return $bytes;
    }
    protected function Arr2Str($bytes){
        $str='';
        for($i=0;$i<count($bytes);$i++)$str.=chr($bytes[$i]);
        return $str;
    }
}
