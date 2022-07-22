<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Application;

use DOMAttr;
use DOMElement;
use JesusValera\Anmeldung\Domain\AppointmentClientInterface;
use JesusValera\Anmeldung\Domain\ValueObject\Appointment;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use Symfony\Component\DomCrawler\Crawler as SymfonyCrawler;

final class SearcherSlotCrawler
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

        $this->loadLocations();

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

    private function loadLocations(): void
    {
        foreach ($this->availableSlots as $availableSlot) {
            $html = $this->client->getHtmlFrom($availableSlot->getUrl());
            $symfonyCrawler = new SymfonyCrawler($html);
            $tableRows = $symfonyCrawler->filter('.calendar-table .timetable table tbody tr');

            /** @var DOMElement $item */
            foreach ($tableRows->getIterator() as $item) {
                /** @var DOMElement $td */
                $td = $item->childNodes->item(3);
                /** @var DOMElement $a */
                $a = $td->childNodes->item(1);
                $url = $a->attributes->item(0)->nodeValue;
                $title = trim((string) $a->nodeValue);

                $appointment = Appointment::create($title, $url);

                $availableSlot->addAppointment($appointment);
            }
        }
    }
}
