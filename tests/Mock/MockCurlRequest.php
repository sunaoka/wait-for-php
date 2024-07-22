<?php

declare(strict_types=1);

namespace Tests\Mock;

use Sunaoka\WaitFor\Request\RequestException;
use Sunaoka\WaitFor\Request\RequestInterface;

/**
 * @implements RequestInterface<\CurlHandle>
 */
class MockCurlRequest implements RequestInterface
{
    public function __construct(
        private false|string $result,
        private ?RequestException $requestException = null,
        private ?\CurlHandle $handle = null
    ) {
    }

    public function getHandle(): \CurlHandle
    {
        $this->handle ??= \curl_init();

        return $this->handle;
    }

    public function execute(): false|string
    {
        return $this->result;
    }

    public function getError(): ?RequestException
    {
        return $this->requestException;
    }
}
