<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Domain;

use DOMAttr;
use DOMElement;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use JesusValera\Anmeldung\Infrastructure\AppointmentClientInterface;
use Symfony\Component\DomCrawler\Crawler as SymfonyCrawler;

final class SlotCrawler
{
    /** @var list<AvailableSlot> */
    private array $availableSlots = [];

    public function __construct(
        private AppointmentClientInterface $client
    ) {
    }

    /**
     * @return list<AvailableSlot>
     */
    public function searchSlots(): array
    {
        $this->loadDaySlots($this->client->loadAppointmentPage());
        $this->loadDaySlots($this->client->loadAppointmentPageNextTwoMonths());

        return $this->availableSlots;
    }

    private function loadDaySlots(string $html): void
    {
        $symfonyCrawler = new SymfonyCrawler($html);

        $bookableDays = $symfonyCrawler->filter('.calendar-table .row-fluid .buchbar');
        /** @var DOMElement $bookableDay */
        foreach ($bookableDays as $bookableDay) {
            /** @var DOMElement $childElement */
            $childElement = $bookableDay->childNodes->item(0);
            /** @var array{href:DOMAttr,title:string} $allAttributes */
            $allAttributes = array_map(
                static fn (object $att): object => $att,
                iterator_to_array($childElement->attributes->getIterator())
            );

            $href = $allAttributes['href'];
            $this->availableSlots[] = AvailableSlot::fromUrl($href->value);
        }
    }
}
