<?php

declare(strict_types=1);

namespace JesusValeraTest\Integration;

use Gacela\Framework\ClassResolver\GlobalInstance\AnonymousGlobal;
use JesusValera\Anmeldung\AnmeldungFacade;
use JesusValera\Anmeldung\AnmeldungFactory;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use JesusValera\Anmeldung\Infrastructure\WebClientInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

final class AppointmentCrawlerTest extends TestCase
{
    /**
     * @test
     */
    public function page_is_readable(): void
    {
        AnonymousGlobal::overrideExistingResolvedClass(
            AnmeldungFactory::class,
            new class($this->createWebClient()) extends AnmeldungFactory {
                public function __construct(private WebClientInterface $webClient)
                {
                }

                protected function getWebClient(): WebClientInterface
                {
                    return $this->webClient;
                }
            }
        );

        $facade = new AnmeldungFacade();

        $actual = $facade->findAppointments();
        $expected = [
            AvailableSlot::fromUrl('/terminvereinbarung/termin/time/1654207200/'),
        ];

        self::assertEquals($expected, $actual);
    }

    private function createWebClient(): WebClientInterface
    {
        $webClient = $this->createStub(WebClientInterface::class);
        $webClient->method('waitForVisibility')
            ->willReturnOnConsecutiveCalls(
                $this->createCrawler(),
                $this->createStub(Crawler::class)
            );
        return $webClient;
    }

    private function createCrawler(): Crawler
    {
        $crawler = $this->createStub(Crawler::class);
        $crawler->method('html')
            ->willReturn($this->loadFixtures());

        return $crawler;
    }

    private function loadFixtures(): string
    {
        return file_get_contents(__DIR__ . './../Fixtures/source-code.html');
    }
}
