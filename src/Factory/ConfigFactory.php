<?php


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