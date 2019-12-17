# Zf-Console-Symfony: A ZF3 console app using Symfony Console

## Introduction

`zf-console-symfony` provides a replacement for `zf-console` with a wrapper for the `symfony/console` component.

For developers familiar with ZF3 application, this package provides a scaled-down version of `zend-mvc` that allows the usage of modules and dependency injection using the Service Manager.

## Requirements

Please see the [composer.json](composer.json) file.

## Installation

Run the following `composer` command:

    $ composer require visto9259/zf-console-symfony
    
Or, alternatively, manually add the following to your `composer.json`, in the `require` section:

    "require" : {
        "visto9259/zf-console-symfony" : "^0.1.0"
    }

And then run `composer update` to ensure the module is installed.

## Creating a console application

The console application skeleton is based on the Zend Framework MVC Application skeleton.  It follows a similar directory structure:

    MyApp/
       config/
          autoload/
             global.php
             local.php
             ... other config files
          application.config.php
          modules.config.php
          commands.config.php
          development.config.php (optional)
       module/
          myModule/
            config/
               module.config.php (optional)
            src/
               Module.php
       vendor/
          composer/
          ...
          autoload.php (created by Composer)
       myapp.php (entry point of the application)
       
The `myapp.php` file contains the console application code and can be as simple as:
```php
require __DIR__.'/vendor/autoload.php';
     
use Zend\Stdlib\ArrayUtils;
use ZFSymfonyConsole\Application;
     
// Setup the application
$appConfig = require __DIR__ . '/config/application.config.php';
if (file_exists(__DIR__ . '/config/development.config.php')) {
   $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/config/development.config.php');
}
$application = new Application($appConfig);
     
$exit = $application->run();
```
### Configuring the application

The file `application_config.php` provides the configuration for the console application and for the initialization of the modules using the Zend Framework Module Manager.  It   contains the following:

```php
return [
    'console_application_options' => [
        'name' => 'Test',
        'version' => '0.1',
    ],
    'commands' => require __DIR__ . '/commands.config.php',
    'modules' => require __DIR__ . '/modules.config.php',
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ],
    'service_manager' => [
        // typical Service Manager configation
    ],   
];
```
`console_application_options` contains the `$name` and `$version` arguments passed to `Symfony\Component\Console\Application` constructor.

`commands` is an array of command configurations.  See [Defining Commands](#DefiningCommands) for details.

`modules` and `module_listener_options` are the Module Manager configuration parameters.  

`service_manager` contains the typical ZendFramework Service Manager configuration which allows for services, factories, etc.
 

### <a name="DefiningCommands"></a>Defining commands

To come

## Disclaimer

This package is work-in-progress.  It has not been thoroughly tested for all thinkable cases.  If you find a problem, please log an issue.

