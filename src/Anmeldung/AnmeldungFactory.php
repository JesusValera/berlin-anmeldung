<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractFactory;
use JesusValera\Anmeldung\Domain\SlotCrawler;
use JesusValera\Anmeldung\Infrastructure\AppointmentClient;
use JesusValera\Anmeldung\Infrastructure\AppointmentClientInterface;
use Symfony\Component\Panther;

/**
 * @method anmeldungConfig getConfig()
 */
final class AnmeldungFactory extends AbstractFactory
{
    public function createSlotCrawler(): SlotCrawler
    {
//        $name = $this->getConfig()->getName();
//        $email = $this->getConfig()->getEmail();
//        $details = $this->getConfig()->getDetails();

        return new SlotCrawler($this->createAppointmentClient());
    }

    private function createAppointmentClient(): AppointmentClientInterface
    {
        return new AppointmentClient($this->getClientPanther());
    }

    private function getClientPanther(): Panther\Client
    {
        /** @var Panther\Client $client */
        $client = $this->getProvidedDependency('client_panther');

        return $client;
    }
}
