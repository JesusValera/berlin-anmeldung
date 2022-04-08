<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractFactory;
use JesusValera\Anmeldung\Domain\CrawlerInterface;

/**
 * @method anmeldungConfig getConfig()
 */
final class AnmeldungFactory extends AbstractFactory
{
    public function __construct(
        private CrawlerInterface $crawler
    ) {
    }

    public function findAppointments(): array
    {
//        $name = $this->getConfig()->getName();
//        $email = $this->getConfig()->getEmail();
//        $details = $this->getConfig()->getDetails();

        return $this->crawler->searchSlots();
    }
}
