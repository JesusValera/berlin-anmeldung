<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Domain\ValueObject;

use DateTimeImmutable;
use DateTimeZone;

final class AvailableSlot
{
    /** @var list<Appointment> */
    private array $appointments = [];

    private function __construct(
        private string $url,
        private DateTimeImmutable $dateTime, # Monday, 4th April 2022
    ) {
    }

    /**
     * Example $href value: "/terminvereinbarung/termin/time/1649109600/"
     */
    public static function fromUrl(string $href): self
    {
        $url = 'https://service.berlin.de' . $href;

        $chunks = array_filter(explode('/', $href));
        $timestamp = end($chunks);
        /** @var DateTimeImmutable $dt */
        $dt = DateTimeImmutable::createFromFormat('U', $timestamp);
        $dateTime = $dt->setTimezone(new DateTimeZone('Europe/Berlin'));

        return new self($url, $dateTime);
    }

    public function getDateTimeFormat(string $format = 'l, jS M Y'): string
    {
        return $this->dateTime->format($format);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function addAppointment(Appointment $appointment): void
    {
        $this->appointments[] = $appointment;
    }

    /**
     * @return list<Appointment>
     */
    public function getAppointments(): array
    {
        return $this->appointments;
    }
}
