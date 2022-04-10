<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractFactory;
use JesusValera\Anmeldung\Domain\SlotCrawler;
use JesusValera\Anmeldung\Infrastructure\AppointmentClient;
use JesusValera\Anmeldung\Infrastructure\AppointmentClientInterface;
use JesusValera\Anmeldung\Infrastructure\WebClientInterface;

/**
 * @method AnmeldungConfig getConfig()
 */
class AnmeldungFactory extends AbstractFactory
{
    public function createSlotCrawler(): SlotCrawler
    {
//        $name = $this->getConfig()->getName();
//        $email = $this->getConfig()->getEmail();
//        $details = $this->getConfig()->getDetails();

        return new SlotCrawler($this->createAppointmentClient());
    }

    protected function createAppointmentClient(): AppointmentClientInterface
    {
        return new AppointmentClient($this->getWebClient());
    }

    private function getWebClient(): WebClientInterface
    {
        /** @var WebClientInterface $webClient */
        $webClient = $this->getProvidedDependency('client_panther');

        return $webClient;
    }
}
