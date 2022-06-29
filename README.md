# Laravel Lang: JSON Fallback Hotfix

![laravel lang publisher](https://preview.dragon-code.pro/laravel-lang/json-fallback-hotfix.svg?brand=laravel)

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]

## Installation

To get the latest version of `Laravel Lang: JSON Fallback Hotfix`, simply require the project using Composer:

```bash
composer require laravel-lang/json-fallback-hotfix
```

Next, in the `providers` section of the `config/app.php` file, replace `Illuminate\Translation\TranslationServiceProvider::class`
with `LaravelLang\JsonFallbackHotfix\TranslationServiceProvider::class`.

It's all 😊

## What's fixed

Out of the box, Laravel [doesn't allow](https://github.com/laravel/framework/issues/41565#issuecomment-1073572954) fallback translations for JSON keys.

For example, when you call `__('Remember Me')`, you get `Remember Me` instead of `Se souvenir de moi` for French fallback language.

This package solves this problem.



## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/workflow/status/laravel-lang/json-fallback-hotfix/phpunit?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/laravel-lang/json-fallback-hotfix.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/laravel-lang/json-fallback-hotfix.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/laravel-lang/json-fallback-hotfix?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/laravel-lang/json-fallback-hotfix/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/laravel-lang/json-fallback-hotfix
