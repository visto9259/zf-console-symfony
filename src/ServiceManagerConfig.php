<?php


namespace ZFSymfonyConsole;


use Zend\ServiceManager\Config;
use ZFSymfonyConsole\Factory\ModuleManagerFactory;

class ServiceManagerConfig extends Config
{

    protected $config = [
        'abstract_factories' => [],
        'aliases'            => [],
        'delegators' => [],
        'factories'  => [
            'ModuleManager' => ModuleManagerFactory::class,
        ],
        'lazy_services' => [],
        'initializers'  => [],
        'invokables'    => [],
        'services'      => [],
        'shared'        => [],

    ];

    public function __construct(array $config = [])
    {
        $this->config['factories']['ServiceManager'] = function ($container) {
            return $container;
        };
        parent::__construct($config);
    }
}