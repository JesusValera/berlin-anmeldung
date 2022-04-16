<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Domain;

interface AppointmentClientInterface
{
    public function loadAppointmentPage(): string;

    public function loadAppointmentPageNextTwoMonths(): string;
}
