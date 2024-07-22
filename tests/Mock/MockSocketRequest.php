<?php

declare(strict_types=1);

namespace Tests\Mock;

use Sunaoka\WaitFor\Request\RequestException;
use Sunaoka\WaitFor\Request\RequestInterface;

/**
 * @implements RequestInterface<resource>
 */
class MockSocketRequest implements RequestInterface
{
    /**
     * @param false|resource $handle
     */
    public function __construct(
        private false|string $result,
        private ?RequestException $requestException = null,
        private $handle = false
    ) {
    }

    public function getHandle()
    {
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
