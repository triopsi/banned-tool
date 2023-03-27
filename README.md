# Ban IP Address plugin for CakePHP
A quick way to ban IP addresses. It`s a plugin for CakePHP 4.x.

<p align="center">
    <img height="300" src="banned-tool.png.png">
</p>

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require triopsi/banned-tool
```
## Database migration

Run the following command in the CakePHP console to create the tables using the Migrations plugin:
```sh
bin/cake migrations migrate -p BannedTool
```

## Load Plugin
Via the Load task you are able to load plugins in your config/bootstrap.php. You can do this by running:
```
bin/cake plugin load BannedTool
```

### Manually
Put this in the application.php in the bootstrap method:
```php
$this->addPlugin('BannedTool');
```

## Customizing
Make sure you have a template file in `'templates' . DS . 'Error' . DS` named `banned.php`.

Configs:
- 'className' => View::class,
- 'templatePath' => 'Error',
- 'statusCode' => 503,
- 'templateLayout' => false,
- 'templateFileName' => 'banned',
- 'templateExtension' => '.php',
- 'contentType' => 'text/html'

Those can be used to adjust the content of the maintenance mode page.

## Ban Component
This component adds functionality on top:
- Add ip Address to the banlist
- Remove ip Address from the banlist
- Check if the IP address is in the banlist
- List all banned ip addresses
### How to setup
```php
// In your App Controller Class (src/Controller/AppController)
public function initialize() {
    ...
    $this->loadComponent('BannedTool.Banned');
}
```

## Ban Commands
This should be the preferred way of enabling and disabling the maintenance mode for your application.

Commands
- add ban <ip_addresses>
- rm ban <ip_addresses>
- list bans
