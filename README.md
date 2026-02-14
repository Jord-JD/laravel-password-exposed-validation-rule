# 🔒 Laravel Password Exposed Validation Rule

This package provides a Laravel validation rule that checks if a password has been exposed in a data breach. It uses the haveibeenpwned.com passwords API via the [`divineomega/password_exposed`](https://github.com/Jord-JD/password_exposed) library.

<p align="center">
    <img src="assets/images/laravel-password-exposed.png">
</p>

<p align="center">
    <a href="https://travis-ci.org/Jord-JD/laravel-password-exposed-validation-rule"></a><img src="https://travis-ci.org/Jord-JD/laravel-password-exposed-validation-rule.svg?branch=master" alt="Travis CI"></a>
    <a href='https://coveralls.io/github/Jord-JD/laravel-password-exposed-validation-rule?branch=master'><img src='https://coveralls.io/repos/github/Jord-JD/laravel-password-exposed-validation-rule/badge.svg?branch=master' alt='Coverage Status' /></a>
    <a href="https://styleci.io/repos/131214375"><img src="https://styleci.io/repos/131214375/shield?branch=master" alt="StyleCI"></a>
    <a href="https://packagist.org/packages/jord-jd/laravel-password-exposed-validation-rule/stats"><img src="https://img.shields.io/packagist/dt/jord-jd/laravel-password-exposed-validation-rule.svg"/></a>
</p>

## Installation

To install, just run the following Composer command.

```
composer require jord-jd/laravel-password-exposed-validation-rule
```

Please note that this package requires Laravel 5.1 or above.

## Usage

The following code snippet shows an example of how to use the password exposed validation rule.

```php
use DivineOmega\LaravelPasswordExposedValidationRule\PasswordExposed;

$request->validate([
    'password' => ['required', new PasswordExposed()],
]);
```

If you wish, you can also set a custom validation message, as shown below.

```php
use DivineOmega\LaravelPasswordExposedValidationRule\PasswordExposed;

$request->validate([
    'password' => ['required', (new PasswordExposed())->setMessage('This password is not secure.')],
]);
```
