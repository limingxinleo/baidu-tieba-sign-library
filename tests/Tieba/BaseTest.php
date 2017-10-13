<?php
// +----------------------------------------------------------------------
// | BaseTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Tieba;

use Tests\TestCase;
use Yi\Baidu\Application;
use Yi\Baidu\User;

class BaseTest extends TestCase
{

    public function testConfig()
    {
        $bduss = file_get_contents('bduss');
        $client = new Application([
            'bduss' => $bduss,
        ]);

        $this->assertEquals($bduss, $client->config->bduss);
    }

    public function testSign()
    {
        $bduss = file_get_contents('bduss');
        $client = new Application([
            'bduss' => $bduss,
        ]);
        $res = $client->user->tieba('上海')->sign();
        $this->assertTrue($res['no'] === 0 || $res['no'] === 1101);
    }

    public function testTiebas()
    {
        $bduss = file_get_contents('bduss');
        $nickname = file_get_contents('nickname');
        $client = new Application([
            'bduss' => $bduss,
            'nickname' => '桃园丶龙玉箫'
        ]);

        $result = $client->user->flushTiebas();
        $this->assertTrue(count($result) > 0);
        foreach ($result as $item) {
            $res = $item->sign();
            $this->assertTrue($res['no'] === 0 || $res['no'] === 1101);
        }
    }

    public function testExample()
    {
        $bduss = file_get_contents('bduss');
        $client = new Application([
            'bduss' => $bduss,
        ]);
    }

}