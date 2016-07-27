NeteaseCloudMusicApi
=================
网易云音乐 API - PHP 版  
基于网易云音乐 web 端接口改写的 PHP 版本  
本 API 为个人学习作品，请支持正版音乐，勿滥用

### Function
 - [x] 关键字搜索
 - [x] 获取歌曲地址
 - [x] 歌单解析
 - [x] 专辑解析
 - [x] 单曲解析
 - [x] 歌词解析
 - [x] MV 解析
 - [ ] 移动端新 API

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
# just download the MusicAPI.php into directory, require it with the correct path.
# in version 2, you should put BigInteger.php into same directory, but don't require it.
require_once 'MusicAPI.php';

# Initialize
$api = new MusicAPI();

# Get data
$result = $api->search('hello');
// $result = $api->detail('35847388');
// $result = $api->albums('3377030');
// $result = $api->playlist('124394335');
// $result = $api->url('35847388');
// $result = $api->lyric('35847388');
// $result = $api->mv('501053');

# return JSON, just use it
var_dump(json_decode($result));

```

### Link
 - [METO Blog](https://i-meto.com/)


### License
NeteaseCloudMusicApi is under the MIT license.
