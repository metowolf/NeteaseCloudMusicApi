# NeteaseCloudMusicApi
网易云音乐 API - PHP 版

## Get Started
初始化
```php
// just download the MusicAPI.php into directory, require it with the correct path.
require_once 'MusicAPI.php';

// Initialize
$api = new MusicAPI();
```
搜索歌曲
```php
$result = $api->search($keyword);
```
获取单曲详情
```php
$result = $api->detail($song_id);
```
获取专辑歌曲
```php
$result = $api->albums($album_id);
```
获取歌单歌曲
```php
$result = $api->playlist($playlist_id);
```
获取歌词
```php
$result = $api->lyric($song_id);
```
获取 MV
```php
$result = $api->mv($mv_id);
```

## Thanks
 * base on: [https://github.com/axhello/NeteaseCloudMusicApi](https://github.com/axhello/NeteaseCloudMusicApi)
 * API: [https://github.com/darknessomi/musicbox/wiki/%E7%BD%91%E6%98%93%E4%BA%91%E9%9F%B3%E4%B9%90API%E5%88%86%E6%9E%90](https://github.com/darknessomi/musicbox/wiki/%E7%BD%91%E6%98%93%E4%BA%91%E9%9F%B3%E4%B9%90API%E5%88%86%E6%9E%90)

## Others
很惭愧，做了点微小的工作，帮原作者更新了一下 API。  
仅供个人学习