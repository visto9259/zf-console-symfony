<?php


namespace ZFSymfonyConsole\Factory;


use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractCommandFactory implements AbstractFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName();
    }

    /**
     * @inheritDoc
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return in_array(Command::class, class_parents($requestedName));
    }
}