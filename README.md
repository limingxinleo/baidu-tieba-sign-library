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
foreach ($result as $item) {
    $res = $item->sign();
    $this->assertTrue($res['no'] === 0 || $res['no'] === 1101);
}
~~~