<?php

declare(strict_types=1);

namespace LaravelLang\JsonFallback;

use Illuminate\Translation\Translator as BaseTranslator;

class Translator extends BaseTranslator
{
    public function get($key, array $replace = [], $locale = null, $fallback = true): array|string
    {
        $locale = $locale ?: $this->locale;

        $this->load('*', '*', $locale);

        $line = $this->loaded['*']['*'][$locale][$key] ?? null;

        if ($fallback && $line === null) {
            $this->load('*', '*', $this->fallback);

            $line = $this->loaded['*']['*'][$this->fallback][$key] ?? null;
        }

        if (! isset($line)) {
            [$namespace, $group, $item] = $this->parseKey($key);

            $locales = $fallback ? $this->localeArray($locale) : [$locale];

            foreach ($locales as $languageLineLocale) {
                if (! is_null($line = $this->getLine($namespace, $group, $languageLineLocale, $item, $replace))) {
                    return $line;
                }
            }

            $key = $this->handleMissingTranslationKey($key, $replace, $locale, $fallback);
        }

        return $this->makeReplacements($line ?: $key, $replace);
    }
}
