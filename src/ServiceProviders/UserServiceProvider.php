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

class UserServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['user'] = function ($pimple) {
            $config = $pimple['config'];
            $api = 'https://api.github.com/user';

            $result = Curl::get($api, $config['token']);
            return new User($result);
        };
    }

}