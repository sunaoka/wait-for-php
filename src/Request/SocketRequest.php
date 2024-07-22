<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Request;

/**
 * @implements RequestInterface<resource>
 */
class SocketRequest implements RequestInterface
{
    /**
     * @var false|resource
     */
    private $handle;

    private int $errorCode;
    private string $errorMessage;

    public function __construct(string $hostname, int $port, array $options = [])
    {
        $this->handle = @fsockopen($hostname, $port, $errorCode, $errorMessage, $options['timeout'] ?? 1);

        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    /**
     * @return false|resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    public function execute(): false|string
    {
        /** @var false|string */
        return '';
    }

    public function getError(): ?RequestException
    {
        if (false !== $this->handle) {
            return null;
        }

        return new RequestException($this->errorMessage, $this->errorCode);
    }
}
