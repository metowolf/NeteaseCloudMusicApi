weapi 版本
=================

base url:`music.163.com/weapi/`

本版本目前使用在 网页端

 * music.163.com
 * wechat

目录中的文件：

 * MusicAPI.php 标准版本
 * MusicAPI_early.php 早期版本，返回的结构和 api 版本一致，可用于兼容性升级
 * MusicAPI_mini.php 迷你版本，是标准版本的精简，去除 BigInteger 依赖

**除了迷你版本外，都需要附加 BigInteger.php**
