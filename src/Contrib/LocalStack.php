<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor\Contrib;

use Sunaoka\WaitFor\Response\ResponseInterface;

/**
 * @phpstan-require-extends \Sunaoka\WaitFor\WaitFor
 */
trait LocalStack
{
    /**
     * Checks if a LocalStack server is ready.
     *
     * @param string $url     the URL of the LocalStack server
     * @param int    $timeout The timeout in seconds for the request. Default is 10000 (10 seconds)
     *
     * @return bool returns true if the LocalStack server is ready, false otherwise
     */
    public static function localstack(string $url, int $timeout = 10000): bool
    {
        return self::http("{$url}/_localstack/init/ready", static function (ResponseInterface $response) {
            $result = $response->getResult();
            if (empty($result)) {
                return false;
            }

            /** @var array{completed?: bool} $json */
            $json = json_decode($result, true, 512, JSON_THROW_ON_ERROR);

            return $json['completed'] ?? false;
        }, $timeout);
    }
}
