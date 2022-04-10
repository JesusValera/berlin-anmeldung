<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure;

use DateTimeImmutable;
use Facebook\WebDriver\Exception\NoSuchElementException;
use RuntimeException;
use Symfony\Component\Panther;

final class AppointmentClient implements AppointmentClientInterface
{
    private const BTN_FIND_A_BOOKING_TEXT = 'Termin berlinweit suchen';

    private string $url = 'https://service.berlin.de/dienstleistung/120335/';

    private string $captchaUrl = 'https://service.berlin.de/terminvereinbarung/termin/human/'; // TODO (?)

    public function __construct(
        private Panther\Client $client
    ) {
    }

    public function loadAppointmentPage(): string
    {
        $this->client->request('GET', $this->url);
        $this->client->clickLink(self::BTN_FIND_A_BOOKING_TEXT);

        try {
            $pantherCrawler = $this->client->waitForVisibility('.collapsible-body');
        } catch (NoSuchElementException) {
            throw new RuntimeException(
                sprintf("There was an error when fetching data from URL %s\n", $this->client->getCurrentURL())
            );
        }

        return $pantherCrawler->html();
    }

    public function loadAppointmentPageNextTwoMonths(): string
    {
        $datetime = (new DateTimeImmutable('00:00:00 first day of this month +2 month'));
        $unitTimeNextMonth = $datetime->getTimestamp();
        $this->client->request('GET', $this->client->getCurrentURL() . $unitTimeNextMonth);

        try {
            $pantherCrawler = $this->client->waitForVisibility('.collapsible-body');
        } catch (NoSuchElementException) {
            throw new RuntimeException(
                sprintf("There was an error when fetching data from URL %s\n", $this->client->getCurrentURL())
            );
        }

        return $pantherCrawler->html();
    }
}
