# Laravel Domain Scope
[![Latest version on Packagist](https://img.shields.io/packagist/v/snoeren-development/laravel-domain-scope.svg?style=flat-square)](https://packagist.org/packages/snoeren-development/laravel-domain-scope)
[![Software License](https://img.shields.io/github/license/snoeren-development/laravel-domain-scope?style=flat-square)](LICENSE)
[![Build status](https://img.shields.io/github/workflow/status/snoeren-development/laravel-domain-scope/PHP%20Tests?style=flat-square)](https://github.com/snoeren-development/laravel-domain-scope/actions)
[![Downloads](https://img.shields.io/packagist/dt/snoeren-development/laravel-domain-scope?style=flat-square)](https://packagist.org/packages/snoeren-development/laravel-domain-scope)

This package adds domain-scoped content to your application. Content will be
available based on the current (sub)-domain allowing "multiple" websites to
run off the same code base.

## Installation
1. Install the package using Composer:
```bash
composer require snoeren-development/laravel-domain-scope
```
2. You should then publish all assets to your application using:
```bash
php artisan vendor:publish --provider="SnoerenDevelopment\DomainScope\ServiceProvider"
```
3. Configure the settings in `domain-scope.php` to your likings.
4. Update the migration if you need more information per domain. Reflect this in the model too.
5. Configure the scoped models in `domain-scope.php` by adding their class names.
6. Add the `SnoerenDevelopment\DomainScope\Http\Middleware\DetectDomain` to your
(global) middleware stack.
7. Add (by default) `domain_id` to all your scoped models in the database. Use a constrained foreign id
if you'd like to clear all data when removing a domain, for example:
```php
$table->foreignId('domain_id')->constrained()->cascadeOnDelete();
```

### Requirements
This package requires at least PHP 7.4 and Laravel 8.

## Usage
After installation, it's up to you how to handle domains. For example:
- Create a middleware to throw a 404 when no domain has been matched.
- Letting a unmatched request through to your application's frontpage.
- Ignore `www` and no subdomain to show your frontpage. If another subdomain is available, throw
a 404 when not found or present the application scoped by subdomain.

### Service Container
If a domain has been matched and found, the service container receives two bindings:
"domain" and the full configured model classname. You can use this to retrieve the
currently active domain, for example:
```php
$domain = app('domain');
```

Or in your controllers (or wherever the service container injects):
```php
use App\Models\Domain;

public function index(?Domain $domain): Response
{
    // $domain contains the matched domain or null if not matched.
}
```
**Tip**: Use middleware to enforce a matched domain into your routes to prevent `null`
being passed.

### Models
Scoped models will only return results of the currently active domain. If no domain
has been matched, all results will be returned as no scope has been applied.

## Credits
- [Michael Snoeren](https://github.com/MSnoeren)
- [All Contributors](https://github.com/snoeren-development/laravel-domain-scope/graphs/contributors)

## License
The MIT license. See [LICENSE](LICENSE) for more information.
