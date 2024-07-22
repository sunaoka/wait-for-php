<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Response;

use Sunaoka\WaitFor\Request\RequestException;

class Response implements ResponseInterface
{
    public function __construct(
        private false|string $result,
        private ?RequestException $exception
    ) {
    }

    public function getResult(): false|string
    {
        return $this->result;
    }

    public function getException(): ?RequestException
    {
        return $this->exception;
    }
}
