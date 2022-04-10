<?php

declare(strict_types=1);

namespace JesusValeraTest\Unit\Anmeldung\Domain;

use JesusValera\Anmeldung\Infrastructure\AppointmentClientInterface;

final class FakeAppointmentClient implements AppointmentClientInterface
{
    public function loadAppointmentPage(): string
    {
        return file_get_contents(__DIR__ . '/source-code.html');
    }

    public function loadAppointmentPageNextTwoMonths(): string
    {
        return '';
    }
}
