<?php

declare(strict_types=1);

namespace Tests\Contrib;

use Sunaoka\WaitFor\WaitFor;
use Tests\Mock\MockCurlRequest;
use Tests\TestCase;

class LocalStackTest extends TestCase
{
    public function testLocalstackCompleted(): void
    {
        WaitFor::$request = new MockCurlRequest('{"completed": true}');

        $this->assertTrue(WaitFor::localstack('https://example.com'));
    }

    public function testLocalstackNotCompleted(): void
    {
        WaitFor::$request = new MockCurlRequest('{"completed": false}');

        $this->assertFalse(WaitFor::localstack('https://example.com', 0));
    }

    public function testLocalstackErrorsOccur(): void
    {
        WaitFor::$request = new MockCurlRequest(false);

        $this->assertFalse(WaitFor::localstack('https://example.com', 0));
    }

    public function testLocalstackReturnMalformedJson(): void
    {
        WaitFor::$request = new MockCurlRequest('Malformed JSON');

        $this->assertFalse(WaitFor::localstack('https://example.com', 0));
    }
}
