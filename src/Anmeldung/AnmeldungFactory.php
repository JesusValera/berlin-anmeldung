<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractFactory;
use JesusValera\Anmeldung\Infrastructure\PantherCrawler;

/**
 * @method anmeldungConfig getConfig()
 */
final class AnmeldungFactory extends AbstractFactory
{
    public function findAppointments(): array
    {
        $name = $this->getConfig()->getName();
        $email = $this->getConfig()->getEmail();
        $details = $this->getConfig()->getDetails();

        dump($name);
        dump($email);
        dump($details);

        return $this->createCrawler()
            ->searchSlots();
    }

    private function createCrawler(): PantherCrawler
    {
        return new PantherCrawler();
    }
}
