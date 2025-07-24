<?php

declare(strict_types=1);

namespace Tests\Request;

use Sunaoka\WaitFor\Request\CurlRequest;
use Sunaoka\WaitFor\Request\RequestException;
use Tests\TestCase;

class CurlRequestTest extends TestCase
{
    public function testRequest(): void
    {
        $request = new CurlRequest('https://github.com', []);

        self::assertNotEmpty($request->execute());
        self::assertInstanceOf(\CurlHandle::class, $request->getHandle());
        self::assertNull($request->getError());

        $request = new CurlRequest('', []);

        self::assertFalse($request->execute());
        self::assertInstanceOf(\CurlHandle::class, $request->getHandle());
        self::assertInstanceOf(RequestException::class, $request->getError());
    }
}
