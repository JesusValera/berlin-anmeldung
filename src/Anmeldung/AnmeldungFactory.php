<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractFactory;
use JesusValera\Anmeldung\Application\SearcherSlotCrawler;
use JesusValera\Anmeldung\Domain\AppointmentClient;
use JesusValera\Anmeldung\Domain\AppointmentClientInterface;
use JesusValera\Anmeldung\Infrastructure\IO\ConsolePrinter;
use JesusValera\Anmeldung\Infrastructure\WebClientInterface;

/**
 * @method AnmeldungConfig getConfig()
 */
class AnmeldungFactory extends AbstractFactory
{
    public function createSlotCrawler(): SearcherSlotCrawler
    {
        return new SearcherSlotCrawler($this->createAppointmentClient());
    }

    protected function getWebClient(): WebClientInterface
    {
        /** @var WebClientInterface $webClient */
        $webClient = $this->getProvidedDependency('client_panther');

        return $webClient;
    }

    private function createAppointmentClient(): AppointmentClientInterface
    {
        return new AppointmentClient($this->getWebClient());
    }

    public function createPrinter(): ConsolePrinter
    {
        return new ConsolePrinter(
            $this->getConfig()->getOptions()
        );
    }
}
