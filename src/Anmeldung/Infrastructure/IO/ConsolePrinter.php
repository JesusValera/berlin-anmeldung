<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure\IO;

use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;

use function count;

final class ConsolePrinter
{
    public function print(array $availableSlots): void
    {
        if (empty($availableSlots)) {
            echo 'No spots found, try again in another moment' . PHP_EOL;
            return;
        }

        echo count($availableSlots) . ' spots found' . PHP_EOL;

        /** @var AvailableSlot[] $availableSlots */
        foreach ($availableSlots as $key => $availableSlot) {
            echo sprintf(
                '%d. %s: (%s appointment%s available) %s' . PHP_EOL,
                ((int) $key + 1),
                $availableSlot->getDateTimeFormat(),
                count($availableSlot->getAppointments()),
                count($availableSlot->getAppointments()) > 1 ? 's' : '',
                $availableSlot->getUrl()
            );
            foreach ($availableSlot->getAppointments() as $appointment) {
                echo sprintf(
                    "\t %s - %s: %s" . PHP_EOL,
                    $appointment->getDateTimeFormat(),
                    $appointment->getTitle(),
                    $appointment->getUrl()
                );
            }
            echo PHP_EOL;
        }
    }
}
