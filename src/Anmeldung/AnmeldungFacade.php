<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractFacade;

/**
 * @method AnmeldungFactory getFactory()
 */
final class AnmeldungFacade extends AbstractFacade
{
    public function findAppointments(): array
    {
        return $this->getFactory()
            ->findAppointments();
    }
}
