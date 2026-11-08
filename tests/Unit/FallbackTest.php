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
