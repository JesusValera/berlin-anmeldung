<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure;

use DateTimeImmutable;
use Facebook\WebDriver\Exception\NoSuchElementException;
use RuntimeException;

final class AppointmentClient implements AppointmentClientInterface
{
    private const BTN_FIND_A_BOOKING_TEXT = 'Termin berlinweit suchen';

    private const URL = 'https://service.berlin.de/dienstleistung/120335/';

    private const CAPTCHA_URL = 'https://service.berlin.de/terminvereinbarung/termin/human/'; // TODO (?)

    public function __construct(
        private WebClientInterface $client,
    ) {
    }

    public function loadAppointmentPage(): string
    {
        $this->client->request('GET', self::URL);
        $this->client->clickLink(self::BTN_FIND_A_BOOKING_TEXT);

        return $this->returnHtmlResponse();
    }

    public function loadAppointmentPageNextTwoMonths(): string
    {
        $datetime = (new DateTimeImmutable('00:00:00 first day of this month +2 month'));
        $unitTimeNextMonth = $datetime->getTimestamp();
        $this->client->request('GET', $this->client->getCurrentURL() . $unitTimeNextMonth);

        return $this->returnHtmlResponse();
    }

    private function returnHtmlResponse(): string
    {
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
