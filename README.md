# baidu-tieba-sign-library
百度贴吧 签到扩展包

## 安装
~~~
composer require limingxinleo/baidu-tieba-sign-library
~~~

## 使用
~~~php
<?php 
use Yi\Baidu\Application;

$client = new Application([
    'bduss' => $bduss,
    'nickname' => 'Your Nick Name'
]);

$result = $client->user->flushTiebas();
$this->assertTrue(count($result) > 0);

/** @var \Yi\Baidu\User\Tieba $item */
foreach ($result as $item) {
    $res = $item->sign();
    $this->assertTrue($res['no'] === 0 || $res['no'] === 1101);
}
~~~

## 配置
~~~
bduss: 登录百度贴吧网页，打开F12，从cookies中找到BDUSS
nickname：就是你的昵称
~~~