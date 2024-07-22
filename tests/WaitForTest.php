<?php

declare(strict_types=1);

namespace Tests;

use Sunaoka\WaitFor\WaitFor;
use Tests\Mock\MockCurlRequest;

class WaitForTest extends TestCase
{
    public function testItReturnsTrue(): void
    {
        WaitFor::$request = new MockCurlRequest('');

        $this->assertTrue(WaitFor::http('https://example.com', static fn () => true));
    }

    public function testItReturnsFalse(): void
    {
        WaitFor::$sleep = 0;
        WaitFor::$request = new MockCurlRequest('');

        $this->assertFalse(WaitFor::http('https://example.com', static fn () => false, 1));
    }
}
