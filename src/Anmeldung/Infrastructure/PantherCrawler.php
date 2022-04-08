<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure;

use DateTimeImmutable;
use DOMElement;
use Facebook\WebDriver\Exception\NoSuchElementException;
use JesusValera\Anmeldung\Domain\CrawlerInterface;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther;

final class PantherCrawler implements CrawlerInterface
{
    private const BTN_FIND_A_BOOKING_TEXT = 'Termin berlinweit suchen';

    private string $url = 'https://service.berlin.de/dienstleistung/120335/';

    private string $captchaUrl = 'https://service.berlin.de/terminvereinbarung/termin/human/'; // TODO (?)

    /** @var list<AvailableSlot> */
    private array $availableSlots = [];

    private Panther\Client $client;

    public function __construct()
    {
        $this->client = Panther\Client::createFirefoxClient();
    }

    public function searchSlots(): array
    {
        $this->loadAppointmentPage();
        $this->loadAppointmentPageNextTwoMonths();

        return $this->availableSlots;
    }

    private function loadAppointmentPage(): void
    {
        $this->client->request('GET', $this->url);
        $this->client->clickLink(self::BTN_FIND_A_BOOKING_TEXT);

        $this->loadDaySlots();
    }

    private function loadDaySlots(): void
    {
        try {
            $pantherCrawler = $this->client->waitForVisibility('.collapsible-body');
        } catch (NoSuchElementException) {
            echo sprintf("There was an error when fetching data from URL %s\n", $this->client->getCurrentURL());
            return;
        }

        $html = $pantherCrawler->html();
        $symfonyCrawler = new Crawler($html);

        $bookableDays = $symfonyCrawler->filter('.calendar-table .row-fluid .buchbar');
        /** @var DOMElement $bookableDay */
        foreach ($bookableDays as $bookableDay) {
            /** @var DOMElement $childElement */
            $childElement = $bookableDay->childNodes->item(0);
            /** @var array{href:string,title:string} $allAttributes */
            $allAttributes = array_map(
                static fn (object $att): object => $att,
                iterator_to_array($childElement->attributes->getIterator())
            );

            $href = $allAttributes['href'];
            $this->availableSlots[] = AvailableSlot::fromUrl($href);
        }
    }

    private function loadAppointmentPageNextTwoMonths(): void
    {
        $datetime = (new DateTimeImmutable('00:00:00 first day of this month +2 month'));
        $unitTimeNextMonth = $datetime->getTimestamp();
        $this->client->request('GET', $this->client->getCurrentURL() . $unitTimeNextMonth);

        $this->loadDaySlots();
    }
}
