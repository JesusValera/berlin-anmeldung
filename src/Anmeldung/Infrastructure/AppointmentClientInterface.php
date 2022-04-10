<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure;

interface AppointmentClientInterface
{
    public function loadAppointmentPage(): string;

    public function loadAppointmentPageNextTwoMonths(): string;
}
