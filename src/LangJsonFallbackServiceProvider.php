<?php

declare(strict_types=1);

namespace LaravelLang\JsonFallback;

use Illuminate\Foundation\Application;
use Illuminate\Translation\TranslationServiceProvider as BaseServiceProvider;

class LangJsonFallbackServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->registerLoader();

        $this->app->singleton('translator', function (Application $app): OverridedTranslator {
            $loader = $app['translation.loader'];

            $trans = new OverridedTranslator($loader, $app->getLocale());

            $trans->setFallback($app->getFallbackLocale());

            return $trans;
        });
    }
}
