<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Contrib;

use Sunaoka\WaitFor\Response\ResponseInterface;

/**
 * @phpstan-require-extends \Sunaoka\WaitFor\WaitFor
 */
trait PostgreSQL
{
    /**
     * Checks if a PostgreSQL server is ready.
     *
     * @param string $host    the host of the PostgreSQL server
     * @param int    $port    The port of the PostgreSQL server. Default is 5432
     * @param int    $timeout The timeout in milliseconds for the request. Default is 10000 (10 seconds)
     *
     * @return bool Returns true if the PostgreSQL server is ready, false
     */
    public static function postgres(string $host, int $port = 5432, int $timeout = 10000): bool
    {
        return self::socket($host, $port, static function (ResponseInterface $response) {
            return null === $response->getException();
        }, $timeout);
    }
}
