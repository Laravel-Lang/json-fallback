<?php

declare(strict_types=1);

namespace LaravelLang\JsonFallback;

use Illuminate\Contracts\Translation\Loader;
use Illuminate\Foundation\Application;
use Illuminate\Translation\TranslationServiceProvider as BaseServiceProvider;
use LaravelLang\Exceptions\InvalidTranslationLoaderException;

final class LangJsonFallbackServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->registerLoader();

        $this->app->singleton('translator', function (Application $app): OverridedTranslator {
            $loader = $app['translation.loader'];

            if (! $loader instanceof Loader) {
                throw new InvalidTranslationLoaderException;
            }

            $trans = new OverridedTranslator($loader, $app->getLocale());

            $trans->setFallback($app->getFallbackLocale());

            return $trans;
        });
    }
}
