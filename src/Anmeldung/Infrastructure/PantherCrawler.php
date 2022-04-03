<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;

final class PantherCrawler
{
    private const BTN_FIND_A_BOOKING_TEXT = 'Termin berlinweit suchen';

    private string $url = 'https://service.berlin.de/dienstleistung/120335/';

    /**
     * @var array{uri?:list<string>, month-table?:list<string>, nichtbuchbar?:list<\DOMElement>,buchbar?:list<\DOMElement>}
     */
    private array $items = [];

    private Client $client;

    public function __construct()
    {
        $this->client = Client::createFirefoxClient();
    }

    public function searchSlots(): array
    {
        $this->loadAppointmentPage();
        $this->loadAppointmentPageNextMonth();

        return $this->items;
    }

    private function loadAppointmentPage(): void
    {
        $this->client->request('GET', $this->url);
        $this->client->clickLink(self::BTN_FIND_A_BOOKING_TEXT);

        $this->loadDaySlots();
    }

    private function loadDaySlots(): void
    {
        $pantherCrawler = $this->client->waitForVisibility('.collapsible-body');

        $html = $pantherCrawler->html();
        $symfonyCrawler = new Crawler($html);

        $this->items['uri'][] = $pantherCrawler->getUri() ?? '';
        $this->items['month-table'][] = $symfonyCrawler->filter('.calendar-table .row-fluid')->html();
        $this->items['nichtbuchbar'][] = $symfonyCrawler->filter('.calendar-table .row-fluid .nichtbuchbar');
        $this->items['buchbar'][] = $symfonyCrawler->filter('.calendar-table .row-fluid .buchbar');
    }

    private function loadAppointmentPageNextMonth(): void
    {
        $datetime = (new \DateTimeImmutable('first day of next month 00:00:00'));
        $unitTimeNextMonth = $datetime->getTimestamp();
        $this->client->request('GET', $this->client->getCurrentURL() . $unitTimeNextMonth);

        $this->loadDaySlots();
    }
}
