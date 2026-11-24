<?php

declare(strict_types=1);

namespace LaravelLang\JsonFallback;

use Illuminate\Translation\Translator;
use LaravelLang\Exceptions\InvalidTranslationValueException;

final class OverridedTranslator extends Translator
{
    /** @param  string  $key */
    public function has($key, $locale = null, $fallback = true): bool
    {
        if (parent::has($key, $locale, $fallback)) {
            return true;
        }

        if (! $fallback) {
            return false;
        }

        return isset($this->loaded['*']['*'][$this->fallback][$key]);
    }

    /**
     * @param  array<array-key, mixed>  $replace
     * @return array<array-key, mixed>|string
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true): array|string
    {
        $locale = $locale ?: $this->locale;

        // For JSON translations, there is only one file per locale, so we will simply load
        // that file and then we will be ready to check the array for the key. These are
        // only one level deep so we do not need to do any fancy searching through it.
        $this->load('*', '*', $locale);

        $line = $this->loaded['*']['*'][$locale][$key] ?? null;

        if ($fallback && $line === null) {
            $this->load('*', '*', $this->fallback);

            $line = $this->loaded['*']['*'][$this->fallback][$key] ?? null;
        }

        // If we can't find a translation for the JSON key, we will attempt to translate it
        // using the typical translation file. This way developers can always just use a
        // helper such as __ instead of having to pick between trans or __ with views.
        if (! isset($line)) {
            [$namespace, $group, $item] = $this->parseKey($key);

            // Here we will get the locale that should be used for the language line. If one
            // was not passed, we will use the default locales which was given to us when
            // the translator was instantiated. Then, we can load the lines and return.
            $locales = $fallback ? $this->localeArray($locale) : [$locale];

            foreach ($locales as $languageLineLocale) {
                if (! is_null($line = $this->getLine($namespace, $group, $languageLineLocale, $item, $replace))) {
                    return $line;
                }
            }

            $key = $this->handleMissingTranslationKey($key, $replace, $locale, $fallback);
        }

        // If the line doesn't exist, we will return back the key which was requested as
        // that will be quick to spot in the UI if language keys are wrong or missing
        // from the application's language files. Otherwise we can return the line.
        $line = $line ?: $key;

        if ($replace !== []) {
            return $this->makeReplacements($line, $replace);
        }

        if (is_string($line) || is_array($line)) {
            return $line;
        }

        throw new InvalidTranslationValueException;
    }
}
