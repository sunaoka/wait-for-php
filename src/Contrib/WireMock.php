<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Contrib;

use Sunaoka\WaitFor\Response\ResponseInterface;

/**
 * @phpstan-require-extends \Sunaoka\WaitFor\WaitFor
 */
trait WireMock
{
    /**
     * Checks if a WireMock server is ready.
     *
     * @param string $url     the URL of the WireMock server
     * @param int    $timeout The timeout in milliseconds for the request. Default is 10000 (10 seconds)
     *
     * @return bool returns true if the WireMock server is ready, false otherwise
     */
    public static function wiremock(string $url, int $timeout = 10000): bool
    {
        return self::http("{$url}/__admin/health", static function (ResponseInterface $response) {
            $result = $response->getResult();
            if (empty($result)) {
                return false;
            }

            /** @var array{status?: string} $json */
            $json = json_decode($result, true, 512, JSON_THROW_ON_ERROR);

            return ($json['status'] ?? '') === 'healthy';
        }, $timeout);
    }
}
