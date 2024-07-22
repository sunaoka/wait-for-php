<?php

declare(strict_types=1);

namespace Tests;

use Sunaoka\WaitFor\WaitFor;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        WaitFor::$quiet = true;
        WaitFor::$request = null;
        WaitFor::$sleep = 1000;
    }
}
