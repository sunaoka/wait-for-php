<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Response;

use Sunaoka\WaitFor\Request\RequestException;

interface ResponseInterface
{
    public function getResult(): false|string;

    public function getException(): ?RequestException;
}
