<?php

declare(strict_types=1);

namespace Knp\Tests;

use DateTimeImmutable;
use DateTimeZone;
use Haikara\Clock\SnapClock;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\TestCase;

class SnapClockTest extends TestCase
{

    public function test_createFromDatetime(): void {
        $now = new DateTimeImmutable();
        $clock = SnapClock::createFromDatetime($now);

        $this->assertEquals($clock->now(), $now);
    }

    public function test_createFromRequest(): void {
        $request = ServerRequestFactory::fromGlobals();
        $clock = SnapClock::createFromRequest($request);

        $serverParams = $request->getServerParams();
        $now = (new DateTimeImmutable())->setTimestamp((int)$serverParams['REQUEST_TIME']);

        $this->assertEquals($clock->now(), $now);
    }

    public function test_withTimezone(): void {
        $timezone = new DateTimeZone('Arctic/Longyearbyen');
        $clock = SnapClock::createFromDatetime()
            ->withTimeZone($timezone);

        $this->assertEquals(
            $clock->now()->getTimezone(),
            $timezone
        );
    }

    public function test_now(): void {
        $clock = SnapClock::createFromDatetime();

        $this->assertEquals($clock->now(), $clock->now());
    }
}