<?php

declare(strict_types=1);

namespace JesusValeraTest\Unit\Anmeldung\Domain;

use JesusValera\Anmeldung\Domain\AppointmentClientInterface;

final class FakeAppointmentClient implements AppointmentClientInterface
{
    public function loadAppointmentPage(): string
    {
        return file_get_contents(__DIR__ . './../../../Fixtures/calendar-appointment.html');
    }

    public function loadAppointmentPageNextTwoMonths(): string
    {
        return '';
    }

    public function getHtmlFrom(string $url): string
    {
        return file_get_contents(__DIR__ . './../../../Fixtures/date-single-appointment.html');
    }
}
