# 🔒 Laravel Password Exposed Validation Rule

This package provides a Laravel validation rule that checks if a password has been exposed in a data breach. It uses the haveibeenpwned.com passwords API via the [`jord-jd/password_exposed`](https://github.com/Jord-JD/password_exposed) library.

```php
// composer require jord-jd/laravel-password-exposed-validation-rule

use JordJD\LaravelPasswordExposedValidationRule\PasswordNotExposed;

$request->validate([
    'password' => ['required', new PasswordNotExposed()],
]);
```

## Compatibility

- PHP: 7.4+ and 8.x
- Laravel: 8.x through 12.x

## Installation

To install, just run the following Composer command.

```
composer require jord-jd/laravel-password-exposed-validation-rule
```

Please note that this package requires Laravel 8.0 or above.

## Usage

The following code snippet shows an example of how to use the password exposed validation rule.

```php
use JordJD\LaravelPasswordExposedValidationRule\PasswordNotExposed;

$request->validate([
    'password' => ['required', new PasswordNotExposed()],
]);
```

If you wish, you can also set a custom validation message, as shown below.

```php
use JordJD\LaravelPasswordExposedValidationRule\PasswordNotExposed;

$request->validate([
    'password' => ['required', (new PasswordNotExposed())->setMessage('This password is not secure.')],
]);
```

## Backward Compatibility

`PasswordExposed` remains available as a backwards-compatible alias for `PasswordNotExposed`.

## Testing / Mocking

If you need deterministic tests, you can inject a checker directly or use a resolver.

```php
use JordJD\LaravelPasswordExposedValidationRule\PasswordNotExposed;
use JordJD\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;

$fakeChecker = new class implements PasswordExposedCheckerInterface {
    // Implement interface methods for your test scenario...
};

PasswordNotExposed::resolvePasswordExposedCheckerUsing(function () use ($fakeChecker) {
    return $fakeChecker;
});
```
