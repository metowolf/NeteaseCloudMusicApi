NeteaseCloudMusicApi
=================
网易云音乐 API - PHP 版  
基于网易云音乐 web 端接口改写的 PHP 版本， 建议 PHP 5.6 以上环境  
本 API 为个人学习作品，请支持正版音乐，勿滥用

### Function
 - [x] 关键字搜索
 - [x] 歌手热门单曲
 - [x] 歌曲详细信息
 - [x] 专辑解析
 - [x] 歌单解析
 - [x] 歌曲地址获取
 - [x] 歌词解析
 - [x] MV 解析

### Thanks
| Name                 | License | Author        | Link                              |
| :---:                | :---:   | :---:         | :---:                             |
| Math_BigInteger      | MIT     | Jim Wigginton | [PHP](https://pear.php.net/package/Math_BigInteger)|
| Algorithm            | -       | stkevintan    | [Blog](http://sfork.coding.me/2015/07/23/nwmusicboxapi/)|
| NetEase-MusicBox     | MIT     | darknessomi   | [Github](https://github.com/darknessomi/musicbox)|
| NeteaseCloudMusicApi | MIT     | axhello       | [Github](https://github.com/axhello/NeteaseCloudMusicApi)|
| NeteaseCloud Music   | -       | Netease Inc.  | [LINK](http://www.163.com/)|


### Get Started

```php
<?php
# just download the NeteaseMusicAPI.php into directory, require it with the correct path.
# in weapi, you should also put BigInteger.php into same directory, but don't require it.
require_once 'NeteaseMusicAPI.php';

# Initialize
$api = new NeteaseMusicAPI();

# Get data
$result = $api->search('hello');
// or $result = $api->mini()->search('hello');
// $result = $api->artist('46487');
// $result = $api->detail('35847388');
// $result = $api->album('3377030');
// $result = $api->playlist('124394335');
// $result = $api->url('35847388'); # v2 only
// $result = $api->lyric('35847388');
// $result = $api->mv('501053');

# return JSON, just use it
$data=json_decode($result);
header('Content-type: application/json; charset=UTF-8');
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
```

```json
{
    "result": {
        "songs": [
            {
                "rtUrls": [],
                "ar": [
                    {
                        "id": 46487,
                        "name": "Adele"
                    }
                ],
                "al": {
                    "id": 3377030,
                    "name": "Hello",
                    "pic_str": "3388694837506899",
                    "pic": 3388694837506899
                },
                "st": 0,
                "a": null,
                "m": {
                    "br": 160000,
                    "fid": 18575149440043431,
                    "size": 5911555,
                    "vd": -2.95
                },
                "l": {
                    "br": 96000,
                    "fid": 3401888991069698,
                    "size": 3546951,
                    "vd": -2.98
                },
                "rtUrl": null,
                "pst": 0,
                "dt": 295502,
                "alia": [],
                "pop": 100,
                "rt": null,
                "mst": 9,
                "cp": 390012,
                "crbt": null,
                "mv": 501053,
                "cf": "",
                "h": {
                    "br": 320000,
                    "fid": 3420580735976517,
                    "size": 11823064,
                    "vd": -3.39
                },
                "t": 0,
                "djId": 0,
                "fee": 0,
                "ftype": 0,
                "rtype": 0,
                "rurl": null,
                "v": 13,
                "cd": "",
                "no": 1,
                "name": "Hello",
                "id": 35847388,
                "privilege": {
                    "id": 35847388,
                    "fee": 0,
                    "payed": 0,
                    "st": 0,
                    "pl": 320000,
                    "dl": 320000,
                    "sp": 7,
                    "cp": 1,
                    "subp": 1,
                    "cs": false,
                    "maxbr": 999000,
                    "fl": 320000,
                    "toast": false,
                    "flag": 0
                }
            },
            ...
        ],
        "songCount": 9999
    },
    "code": 200
}
```

### Link
 - [METO Blog](https://i-meto.com/)
 - [DEMO](https://music.i-meto.com/netease)  

### License
NeteaseCloudMusicApi is under the MIT license.
