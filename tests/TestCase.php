<?php

/**
 * This file is part of the "dragon-code/json-fallback" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/json-fallback
 */

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Translation\TranslationServiceProvider;
use LaravelLang\JsonFallback\TranslationServiceProvider as FixedServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    protected $lang_path;

    protected function setUp(): void
    {
        parent::setUp();

        $this->copyFixtures();
    }

    protected function defineEnvironment($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', 'en');
        $config->set('app.fallback_locale', 'fr');
    }

    protected function overrideApplicationProviders($app)
    {
        return [
            TranslationServiceProvider::class => FixedServiceProvider::class,
        ];
    }

    protected function copyFixtures(): void
    {
        $path = $this->langPath();

        File::deleteDirectory($path);
        File::makeDirectory($path);

        File::copyDirectory($this->lang_path, $path);
    }

    protected function langPath()
    {
        foreach (['lang', 'resources/lang'] as $directory) {
            if ($path = realpath(base_path($directory))) {
                return $path;
            }
        }

        throw new RuntimeException('Unknown Locales Directory');
    }
}
