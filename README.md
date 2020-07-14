# Summon
With this package you'll be able to generate boilerplate packages for your project right from the command line.

## Installation

Install the package via composer:
```
composer require arctic/summon
```
For development it's best to symlink the packages. By default we will store the packages in `/packages`,
so make sure to add the following lines to `composer.json` to enable symlinking:

```
"repositories": [
    {
        "type": "path",
        "url": "../packages/*",
        "symlink": true
    }
]
```

The config file can be published with:
```
php artisan vendor:publish --provider="Arctic\Summon\SummonServiceProvider" --tag="config"
```

## Usage

```
php artisan summon [PACKAGE NAME]
```

You will be asked a couple of questions to set some author details and the namespace for your package.
Some of these values can be added to the config file so they will be set by default

```php
return [
    'path' => 'packages', // Your packages will be stored here.
    'replacements' => [
        'author_email' => 'you@domain.com',
        'author_name' => 'Jane Doe',
        'author_role' => 'Developer',
        'package_description' => 'This package has been auto-generated by Summon',
        'namespace' => 'Arctic',
    ],
    'files' => [
        '/composer.json',
        '/src/config/package.php',
        '/src/ClassName.php.stub',
        '/src/ClassNameFacade.php.stub',
        '/src/ClassNameServiceProvider.php.stub',
    ]
];
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
