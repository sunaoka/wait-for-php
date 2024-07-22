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
        $request = new CurlRequest('https://example.com', []);

        self::assertNotEmpty($request->execute());
        self::assertInstanceOf(\CurlHandle::class, $request->getHandle());
        self::assertNull($request->getError());

        $request = new CurlRequest('', []);

        self::assertFalse($request->execute());
        self::assertInstanceOf(\CurlHandle::class, $request->getHandle());
        self::assertInstanceOf(RequestException::class, $request->getError());
        self::assertSame('URL rejected: Malformed input to a URL function', $request->getError()->getMessage());
        self::assertSame(3, $request->getError()->getCode());
    }
}
