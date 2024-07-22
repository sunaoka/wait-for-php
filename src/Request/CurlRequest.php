<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Request;

/**
 * @implements RequestInterface<\CurlHandle>
 */
class CurlRequest implements RequestInterface
{
    private \CurlHandle $handle;

    public function __construct(string $url, array $options = [])
    {
        $this->handle = curl_init();

        curl_setopt($this->handle, CURLOPT_TIMEOUT, 1);

        curl_setopt_array($this->handle, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ] + $options);
    }

    public function __destruct()
    {
        curl_close($this->handle);
    }

    public function getHandle(): \CurlHandle
    {
        return $this->handle;
    }

    public function execute(): false|string
    {
        /** @var false|string */
        return curl_exec($this->handle);
    }

    public function getError(): ?RequestException
    {
        $error = curl_errno($this->handle);
        if (0 === $error) {
            return null;
        }

        return new RequestException(curl_error($this->handle), $error);
    }
}
