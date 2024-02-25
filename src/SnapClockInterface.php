<?php

declare(strict_types=1);

namespace Haikara\Clock;

use DateTimeInterface;
use DateTimeZone;
use Psr\Clock\ClockInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SnapClockInterface extends ClockInterface
{
    /**
     * @param DateTimeInterface|null $now
     * @return static
     */
    public static function createFromDatetime(?DateTimeInterface $now = null): static;

    /**
     * Requestの時刻からClockを生成する
     *
     * @param ServerRequestInterface $request
     * @return static
     */
    public static function createFromRequest(ServerRequestInterface $request): static;

    /**
     * @param DateTimeZone $timezone
     * @return $this
     */
    public function withTimeZone(DateTimeZone $timezone): static;
}