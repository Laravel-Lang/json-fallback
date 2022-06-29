<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class FallbackTest extends TestCase
{
    protected $lang_path = __DIR__ . '/../fixtures/fallback';

    public function testPhp(): void
    {
        $this->assertSame('French Custom Failed', __('custom.failed'));
        $this->assertSame('French Custom Password', __('custom.password'));
    }

    public function testJson(): void
    {
        $this->assertSame('French Remember Me', __('Remember Me'));
        $this->assertSame('French You are logged in!', __('You are logged in!'));
    }
}
