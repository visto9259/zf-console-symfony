<?php

/**
 * @see       https://github.com/visto9259/zf-console-symfony for the canonical source repository
 * @copyright Copyright (c) 2019 Eric Richer (eric.richer@vistoconsulting.com)
 * @license   https://github.com/visto9259/zf-console-symfony/LICENSE GNU GENERAL PUBLIC LICENSE
 */

namespace ZFSymfonyConsole\Factory;


use Interop\Container\ContainerInterface;
use Zend\EventManager\EventManager;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Listener\DefaultListenerAggregate;
use Zend\ModuleManager\Listener\ListenerOptions;
use Zend\ModuleManager\Listener\ServiceListener;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class ModuleManagerFactory implements FactoryInterface
{

    protected $defaultServiceConfig = [
        'abstract_factories' => [],
        'aliases'            => [
            'config'        => 'Config',
            'configuration' => 'Config',
            'Configuratio' => 'Config',
        ],
        'delegators' => [],
        'factories'  => [
            'Config' => ConfigFactory::class,
        ],
        'lazy_services' => [],
        'initializers'  => [],
        'invokables'    => [],
        'services'      => [],
        'shared'        => [],

    ];

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $appConfig = $container->get('ApplicationConfig');
        $events = new EventManager();

        $listenerOptions = new ListenerOptions($appConfig['module_listener_options']);
        $listenerDefaultAggregate = new DefaultListenerAggregate($listenerOptions);
        $listenerDefaultAggregate->attach($events);

        $serviceListener = new ServiceListener($container);
        $serviceListener->setDefaultServiceConfig($this->defaultServiceConfig);
        $serviceListener->addServiceManager(
            $container,
            'service_manager',
            ServiceProviderInterface::class,
            'getServiceConfig'
        );
        $serviceListener->attach($events);

        return new ModuleManager($appConfig['modules'], $events);
    }
}