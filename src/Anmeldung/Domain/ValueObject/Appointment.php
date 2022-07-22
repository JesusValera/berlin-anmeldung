<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Domain\ValueObject;

use DateTimeImmutable;
use DateTimeZone;

final class Appointment
{
    private function __construct(
        private string $title,
        private string $url,
        private DateTimeImmutable $dateTime,
    ) {
    }

    /**
     * Example $href value: "/terminvereinbarung/termin/time/1663306200/2908/"
     */
    public static function create(string $title, string $href): self
    {
        $url = 'https://service.berlin.de' . $href;

        $chunks = array_filter(explode('/', $href));
        array_pop($chunks); // we are not interested on the last chunk
        $timestamp = end($chunks);
        /** @var DateTimeImmutable $dt */
        $dt = DateTimeImmutable::createFromFormat('U', $timestamp);
        $dateTime = $dt->setTimezone(new DateTimeZone('Europe/Berlin'));

        return new self($title, $url, $dateTime);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDateTimeFormat(string $format = 'H:i'): string
    {
        return $this->dateTime->format($format);
    }
}
