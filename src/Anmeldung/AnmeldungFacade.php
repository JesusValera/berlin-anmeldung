<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractFacade;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;

/**
 * @method AnmeldungFactory getFactory()
 */
final class AnmeldungFacade extends AbstractFacade
{
    /**
     * @return list<AvailableSlot>
     */
    public function findAppointments(): array
    {
        return $this->getFactory()
            ->createSlotCrawler()
            ->searchSlots();
    }

    /**
     * @param list<AvailableSlot> $appointments
     */
    public function printAppointments(array $appointments): void
    {
        $this->getFactory()
            ->createPrinter()
            ->print($appointments);
    }
}
