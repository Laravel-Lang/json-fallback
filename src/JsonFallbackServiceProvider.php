<?php

declare(strict_types=1);

namespace LaravelLang\JsonFallback;

use Illuminate\Foundation\Application;
use Illuminate\Translation\TranslationServiceProvider;

class JsonFallbackServiceProvider extends TranslationServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->registerLoader();

        $this->app->singleton('translator', function (Application $app) {
            $loader = $app['translation.loader'];

            $locale = $app->getLocale();

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app->getFallbackLocale());

            return $trans;
        });
    }
}
