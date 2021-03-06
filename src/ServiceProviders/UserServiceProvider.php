<?php
// +----------------------------------------------------------------------
// | CurlServiceProvider.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Yi\Baidu\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Yi\Baidu\User;

class UserServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['user'] = function ($pimple) {
            $config = $pimple['config'];

            return new User($config->bduss, $config->nickname);
        };
    }

}