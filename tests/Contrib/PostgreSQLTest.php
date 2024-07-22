<?php

declare(strict_types=1);

namespace Tests\Contrib;

use Sunaoka\WaitFor\Request\RequestException;
use Sunaoka\WaitFor\WaitFor;
use Tests\Mock\MockSocketRequest;
use Tests\TestCase;

class PostgreSQLTest extends TestCase
{
    public function testPostgresReady(): void
    {
        WaitFor::$request = new MockSocketRequest('');

        $this->assertTrue(WaitFor::postgres('localhost'));
    }

    public function testPostgresNotReady(): void
    {
        WaitFor::$request = new MockSocketRequest('', new RequestException('Connection refused', 61));

        $this->assertFalse(WaitFor::postgres('example.com', timeout: 0));
    }
}
