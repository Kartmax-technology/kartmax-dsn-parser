# DSN Parser

A simple DSN parser for PHP projects.

## Installation

Via Composer:
    `composer require yourusername/dsn-parser`

## Usage

```php
$dsnDetails = DsnParser::parse();

## Installation for Laravel

If you're using Laravel 5.5 and above, the package will automatically register its service provider.

For older versions of Laravel:

Add the service provider to the `providers` array in `config/app.php`:

```php
DsnParser\Providers\DsnServiceProvider::class,
```

### Installation for Lumen
Register the service provider in bootstrap/app.php:

`$app->register(DsnParser\Providers\DsnServiceProvider::class);
`
