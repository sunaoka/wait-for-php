<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Request;

/**
 * @template THandle
 */
interface RequestInterface
{
    /**
     * @return THandle|false
     */
    public function getHandle();

    public function execute(): false|string;

    public function getError(): ?RequestException;
}
