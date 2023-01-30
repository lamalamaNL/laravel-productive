# Productive for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lamalama/laravel-productive.svg?style=flat-square)](https://packagist.org/packages/lamalama/laravel-productive)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/lamalama/laravel-productive/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/lamalamanl/laravel-productive/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/lamalama/laravel-productive/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/lamalama/laravel-productive/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lamalama/laravel-productive.svg?style=flat-square)](https://packagist.org/packages/lamalama/laravel-productive)

Laravel-Productive incorporates the Productive API into your Laravel project.

## Installation

You can install the package via composer:

```bash
composer require lamalama/laravel-productive
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="productive-config"
```

This is the contents of the published config file:

```php
return [
    'api_url' => env('PRODUCTIVE_API_URL', 'https://api.productive.io/api/v2'),
    'auth_token' => env('PRODUCTIVE_AUTH_TOKEN'),
    'organization_id' => env('PRODUCTIVE_ORGANIZATION_ID'),
];
```

## Usage

```php
$task = Productive::tasks()->get($taskId);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Mark de Vries](https://github.com/lamalamaMark)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
