<?php
/**
 * @see       https://github.com/visto9259/zf-console-symfony for the canonical source repository
 * @copyright Copyright (c) 2019 Eric Richer (eric.richer@vistoconsulting.com)
 * @license   https://github.com/visto9259/zf-console-symfony/LICENSE GNU GENERAL PUBLIC LICENSE
 */


namespace ZFSymfonyConsole;


use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use ZFSymfonyConsole\Factory\AbstractCommandFactory;

class CommandsConfig
{
    protected $config = [
        'commands' => [],
        'service_manager' => [
            'abstract_factories' => [
                AbstractCommandFactory::class,
            ],
            'aliases'            => [],
            'delegators' => [],
            'factories'  => [],
            'lazy_services' => [],
            'initializers'  => [],
            'invokables'    => [],
            'services'      => [],
            'shared'        => [],

        ],
    ];
    protected $commands = [];

    protected $serviceManagerConfig;

    /**
     * @var ServiceManager
     */
    protected $container;

    public function __construct($config, ServiceManager $container)
    {
        if (!is_array($config)) {
            throw new \Exception('Invalid config');
        }
        $this->config = ArrayUtils::merge($this->config, $config);

        // Setup the service manager config
        $this->container = $container;
        $this->serviceManagerConfig = new Config($this->config['service_manager']);
        $this->serviceManagerConfig->configureServiceManager($this->container);

        // Create the commands
        $this->processCommands($this->config['commands']);
    }



    /**
     * Returns the Service Manager Configuration for Commands
     * @return Config
     */
    public function getServiceManagerConfig()
    {
        return $this->serviceManagerConfig;
    }

    /**
     * Get the command configs
     * @return array
     */
    public function getCommands()
    {
        $commands = [];
        foreach ($this->commands as $config) {
            array_push($commands, $config->getCommand());
        }
        return $commands;
    }

    private function processCommands($commandsConfig)
    {
        if (is_array($commandsConfig)) {
            foreach ($commandsConfig as $config) {
                array_push($this->commands, new CommandConfig($config, $this->container));
            }
        }
    }
}