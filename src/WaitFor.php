<?php

declare(strict_types=1);

namespace Sunaoka\WaitFor;

use Sunaoka\WaitFor\Request\CurlRequest;
use Sunaoka\WaitFor\Request\RequestInterface;
use Sunaoka\WaitFor\Request\SocketRequest;
use Sunaoka\WaitFor\Response\Response;
use Sunaoka\WaitFor\Response\ResponseInterface;

class WaitFor
{
    use Contrib\LocalStack;
    use Contrib\PostgreSQL;
    use Contrib\WireMock;

    public static bool $quiet = false;

    /**
     * Sleep time in milliseconds.
     */
    public static int $sleep = 1000;

    /**
     * @var RequestInterface<covariant mixed>|null
     */
    public static ?RequestInterface $request = null;

    /**
     * @param RequestInterface<covariant mixed> $request  Request object
     * @param \Closure(ResponseInterface): bool $callback Callback function
     * @param int                               $timeout  The timeout in milliseconds for the request. Default is 10000 (10 seconds)
     */
    public function it(RequestInterface $request, \Closure $callback, int $timeout = 10000): bool
    {
        $start = microtime(true) * 1000;

        self::$request ??= $request;

        try {
            while (true) {
                $result = self::$request->execute();
                if ($callback(new Response($result, self::$request->getError()))) {
                    break;
                }

                if (microtime(true) * 1000 - $start > $timeout) {
                    throw new \RuntimeException("Did not ready within {$timeout} milliseconds.");
                }

                if (!self::$quiet) {
                    echo '.';  // @codeCoverageIgnore
                }
                usleep(self::$sleep * 1000);
            }

            if (!self::$quiet) {
                echo ' Done!', PHP_EOL;  // @codeCoverageIgnore
            }
        } catch (\Exception $e) {
            if (!self::$quiet) {
                echo ' Abort! ', $e->getMessage(), PHP_EOL;  // @codeCoverageIgnore
            }

            return false;
        } finally {
            self::$request = null;
        }

        return true;
    }

    /**
     * @param string                            $url      the URL of the server
     * @param \Closure(ResponseInterface): bool $callback Callback function
     * @param int                               $timeout  The timeout in milliseconds for the request. Default is 10000 (10 seconds)
     */
    public static function http(string $url, \Closure $callback, int $timeout = 10000): bool
    {
        self::$request ??= new CurlRequest($url);

        return (new self())->it(self::$request, $callback, $timeout);
    }

    /**
     * @param string                            $hostname Hostname
     * @param int                               $port     Port number
     * @param \Closure(ResponseInterface): bool $callback Callback function
     * @param int                               $timeout  The timeout in milliseconds for the request. Default is 10000 (10 seconds)
     */
    public static function socket(string $hostname, int $port, \Closure $callback, int $timeout = 10000): bool
    {
        self::$request ??= new SocketRequest($hostname, $port);

        return (new self())->it(self::$request, $callback, $timeout);
    }
}
