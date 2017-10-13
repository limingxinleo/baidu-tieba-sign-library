<?php
// +----------------------------------------------------------------------
// | Tieba.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Yi\Baidu;

use Yi\Baidu\Tieba\Tieba;

class TiebaFactory
{
    protected static $_instances = [];

    /**
     * @desc   获取贴吧实例
     * @author limx
     * @param $fid  贴吧fid
     * @param $name 贴吧名
     */
    public static function instance($name, $fid = null)
    {
        if (isset(static::$_instances[$name]) && static::$_instances[$name] instanceof Tieba) {
            return static::$_instances[$name];
        }

        return static::$_instances[$name] = new Tieba($name, $fid);
    }

}