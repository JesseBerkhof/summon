# Wraith
With this package you'll be able to summon boilerplate packages for your project right from the command line.

## Installation
Install the package via composer:
`composer require arctic/wraith`

If you want you can publish the commands with:
`php artisan vendor:publish --provider="Arctic\Wraith\WraithServiceProvider" --tag="commands"`

The config file can be published with:
`php artisan vendor:publish --provider="Arctic\Wraith\WraithServiceProvider" --tag="config"`

## Usage
`php artisan wraith:summon [NAME]`

The package will by default be stored in the `packages` folder. But this can be changed in de config:

```php
    return [
        'folder' => 'path/to/your/folder'
    ];
```
