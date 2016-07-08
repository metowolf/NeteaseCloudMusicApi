<?php
/**
 * @version 1.00
 * @auther METO
 * @update 2016/06/27
 */
class MusicAPI{
    /**
     * 搜索 API，不带 MP3 链接
     * @param $s 要搜索的内容
     * @param $type 类型 [1 单曲] [10 专辑] [100 歌手] [1000 歌单] [1002 用户]
     * @param $limit 返回数据的数目
     * @param $offset 偏移数量，用于分页
     * @return JSON
     */
    public function search($s=null,$type=1,$limit=30,$offset=0){
        $url='http://music.163.com/api/search/get';
        $data='s='.$s.'&limit='.$limit.'&type='.$type.'&offset='.$offset;
        return $this->restAPI($url,$data);
    }
    /**
     * 专辑详情 API
     * @param $album_id 专辑id
     * @return JSON
     */
    public function albums($album_id){
        $url='http://music.163.com/api/album/'.$album_id;
        return $this->restAPI($url);
    }
    /**
     * 歌曲详情 API，带有 MP3 链接，部分新歌失效
     * @param $song_id 歌曲id
     * @return JSON
     */
    public function detail($song_id){
        $url='http://music.163.com/api/song/detail';
        $data='id='.$song_id.'&ids=%5B'.$song_id.'%5D';
        return $this->restAPI($url,$data);
    }
    /**
     * 歌词API
     * @param $song_id 歌曲id
     * @return JSON
     */
    public function lyric($song_id){
        $url='http://music.163.com/api/song/lyric';
        $data='os=pc&id='.$song_id.'&lv=-1&kv=-1&tv=-1';
        return $this->restAPI($url,$data);
    }
    /**
     * MV_API
     * @param $mv_id MV_id
     * @return JSON
     */
    public function mv($mv_id){
        $url='http://music.163.com/api/mv/detail/?id='.$mv_id.'&type=mp4';
        return $this->restAPI($url);
    }
    /**
     * 歌单详情 API
     * @param $playlist_id 歌单id，排行榜也归类为歌单
     * @return JSON
     */
    public function playlist($playlist_id){
        $url='http://music.163.com/api/playlist/detail?id='.$playlist_id.'&updateTime=-1';
        return $this->restAPI($url);
    }
    /**
     * @param $url API地址
     * @param $data Post数据
     * @return result
     */
    protected function restAPI($url,$data=null){
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        if(!empty($data)){
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
            curl_setopt($curl,CURLOPT_POST,1);
        }
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl,CURLOPT_REFERER,'http://music.163.com/');
        curl_setopt($curl,CURLOPT_COOKIE,'appver=2.0.2');
        curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36');
        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    /**
     * 生成加密静态资源地址
     * @param $song_id 歌曲id
     * @return url
     */
    public function get_hd_mp3_url($id){
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
        return "http://m2.music.126.net/".$result.'/'.number_format($id,0,'','').".mp3";
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