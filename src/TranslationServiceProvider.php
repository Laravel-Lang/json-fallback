<?php

declare(strict_types=1);

namespace LaravelLang\JsonFallback;

use Illuminate\Foundation\Application;
use Illuminate\Translation\TranslationServiceProvider as BaseServiceProvider;

class TranslationServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->registerLoader();

        $this->app->singleton('translator', function (Application $app): Translator {
            $loader = $app['translation.loader'];

            $trans = new Translator($loader, $app->getLocale());

            $trans->setFallback($app->getFallbackLocale());

            return $trans;
        });
    }
}
