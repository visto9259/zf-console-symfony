<?php

/**
 * @see       https://github.com/visto9259/zf-console-symfony for the canonical source repository
 * @copyright Copyright (c) 2019 Eric Richer (eric.richer@vistoconsulting.com)
 * @license   https://github.com/visto9259/zf-console-symfony/LICENSE GNU GENERAL PUBLIC LICENSE
 */

namespace ZFSymfonyConsole\Factory;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConfigFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $moduleManager = $container->get('ModuleManager');
        $moduleManager->loadModules();
        $moduleParams = $moduleManager->getEvent()->getParams();
        return $moduleParams['configListener']->getMergedConfig(false);
    }
}