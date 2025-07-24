<?php

declare(strict_types=1);

namespace Tests\Request;

use Sunaoka\WaitFor\Request\RequestException;
use Sunaoka\WaitFor\Request\SocketRequest;
use Tests\TestCase;

class SocketRequestTest extends TestCase
{
    public function testRequest(): void
    {
        $request = new SocketRequest('github.com', 443);

        self::assertSame('', $request->execute());
        self::assertIsResource($request->getHandle());
        self::assertNull($request->getError());

        $request = new SocketRequest('localhost', 80);

        self::assertSame('', $request->execute());
        self::assertFalse($request->getHandle());
        self::assertInstanceOf(RequestException::class, $request->getError());
    }
}
