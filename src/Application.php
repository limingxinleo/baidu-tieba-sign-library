<?php
// +----------------------------------------------------------------------
// | Redis类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Yi\Baidu;

use Pimple\Container;

/**
 * Class Application
 * @package limx\Github
 * @property Config      $config
 * @property User        $user
 * @property Tieba\Tieba $tieba
 */
class Application extends Container
{
    /**
     * Service Providers.
     *
     * @var array
     */
    protected $providers = [
        ServiceProviders\UserServiceProvider::class,
        ServiceProviders\TiebaServiceProvider::class,
    ];

    /**
     * Application constructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        parent::__construct();

        $this['config'] = function () use ($config) {
            return new Config($config);
        };

        $this->registerProviders();

    }


    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * Register providers.
     */
    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }
}