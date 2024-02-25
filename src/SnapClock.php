<?php

declare(strict_types=1);

namespace Haikara\Clock;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Psr\Http\Message\ServerRequestInterface;

class SnapClock implements SnapClockInterface
{
    protected function __construct(protected DateTimeImmutable $now) {
    }

    public static function createFromDatetime(?DateTimeInterface $now = null): static {
        $now ??= new DateTimeImmutable();

        if ($now instanceof DateTime) {
            $now = DateTimeImmutable::createFromMutable($now);
        }

        return new static($now);
    }

    /** @inheritDoc */
    public static function createFromRequest(ServerRequestInterface $request): static {
        $serverParams = $request->getServerParams();

        $now = (new DateTimeImmutable)
            ->setTimestamp($serverParams['REQUEST_TIME'] ?? time());

        return new static($now);
    }

    public function withTimeZone(DateTimeZone $timezone): static {
        $now = $this->now->setTimezone($timezone);
        return static::createFromDatetime($now);
    }

    /** @inheritDoc */
    public function now(): DateTimeImmutable
    {
        return clone $this->now;
    }
}