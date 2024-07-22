<?php

declare(strict_types=1);

namespace Tests\Contrib;

use Sunaoka\WaitFor\WaitFor;
use Tests\Mock\MockCurlRequest;
use Tests\TestCase;

class WireMockTest extends TestCase
{
    public function testWiremockCompleted(): void
    {
        WaitFor::$request = new MockCurlRequest('{"status": "healthy"}');

        $this->assertTrue(WaitFor::wiremock('https://example.com'));
    }

    public function testWiremockNotCompleted(): void
    {
        WaitFor::$request = new MockCurlRequest('{"status": "unhealthy"}');

        $this->assertFalse(WaitFor::wiremock('https://example.com', 0));
    }

    public function testWiremockErrorsOccur(): void
    {
        WaitFor::$request = new MockCurlRequest(false);

        $this->assertFalse(WaitFor::wiremock('https://example.com', 0));
    }

    public function testWiremockReturnMalformedJson(): void
    {
        WaitFor::$request = new MockCurlRequest('Malformed JSON');

        $this->assertFalse(WaitFor::wiremock('https://example.com', 0));
    }
}
