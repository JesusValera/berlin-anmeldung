<?php

declare(strict_types=1);

namespace JesusValeraTest\E2E;

use JesusValera\Anmeldung\Domain\SlotCrawler;
use JesusValera\Anmeldung\Infrastructure\AppointmentClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\Client;

final class AppointmentCrawlerTest extends TestCase
{
    /**
     * @test
     */
    public function page_is_readable(): void
    {
        $symfonyCrawler = new SlotCrawler(new AppointmentClient(Client::createFirefoxClient()));
        $content = $symfonyCrawler->searchSlots();

        self::assertIsArray($content);
    }
}
