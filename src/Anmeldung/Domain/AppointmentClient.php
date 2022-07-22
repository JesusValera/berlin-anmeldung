<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Domain;

use DateTimeImmutable;
use Exception;
use JesusValera\Anmeldung\Domain\Exceptions\NoSuchElementException;
use JesusValera\Anmeldung\Infrastructure\WebClientInterface;

final class AppointmentClient implements AppointmentClientInterface
{
    private const URL = 'https://service.berlin.de/dienstleistungen/';

    private const LINK_BOOKING_AN_APPOINTMENT = 'Anmeldung einer Wohnung';

    private const BTN_FIND_A_BOOKING_TEXT = 'Termin berlinweit suchen';

    private const CAPTCHA_URL = 'https://service.berlin.de/terminvereinbarung/termin/human/'; // TODO (?)

    public function __construct(
        private WebClientInterface $client,
    ) {
    }

    public function loadAppointmentPage(): string
    {
        $this->client->request('GET', self::URL); // List with all available Services
        $this->client->clickLink(self::LINK_BOOKING_AN_APPOINTMENT); // Select 'Anmeldung einer Wohnung' anchor
        $this->client->clickLink(self::BTN_FIND_A_BOOKING_TEXT); // Click on 'Termin berlinweit suchen' button

        return $this->returnHtmlResponse();
    }

    public function loadAppointmentPageNextTwoMonths(): string
    {
        $datetime = (new DateTimeImmutable('00:00:00 first day of this month +2 month'));
        $unitTimeNextMonth = $datetime->getTimestamp();
        $this->client->request('GET', $this->client->getCurrentURL() . $unitTimeNextMonth);

        return $this->returnHtmlResponse();
    }

    public function getHtmlFrom(string $url): string
    {
        $this->client->request('GET', $url);

        try {
            $pantherCrawler = $this->client->waitForVisibility('.calendar-table .timetable');
        } catch (Exception) {
            throw new NoSuchElementException($this->client->getCurrentUrl());
        }

        return $pantherCrawler->html();
    }

    private function returnHtmlResponse(): string
    {
        try {
            $pantherCrawler = $this->client->waitForVisibility('.collapsible-body');
        } catch (Exception) {
            throw new NoSuchElementException($this->client->getCurrentUrl());
        }

        return $pantherCrawler->html();
    }
}
