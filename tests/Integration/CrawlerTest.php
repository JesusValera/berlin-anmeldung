<?php

declare(strict_types=1);

namespace JesusValeraTest\Integration;

use Gacela\Framework\Config\GacelaConfigBuilder\MappingInterfacesBuilder;
use Gacela\Framework\Gacela;
use Gacela\Framework\Setup\SetupGacela;
use JesusValera\Anmeldung\AnmeldungFacade;
use JesusValera\Anmeldung\Domain\CrawlerInterface;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use JesusValera\Anmeldung\Infrastructure\IO\ConsolePrinter;
use PHPUnit\Framework\TestCase;

final class CrawlerTest extends TestCase
{
    /**
     * @test
     */
    public function read_an_parse_a_slot_from_a_fake_file(): void
    {
        $setup = (new SetupGacela())
            ->setMappingInterfaces(
                static function (MappingInterfacesBuilder $mappingInterfacesBuilder): void {
                    $mappingInterfacesBuilder->bind(CrawlerInterface::class, FakeCrawler::class);
                }
            );

        Gacela::bootstrap(__DIR__, $setup);

        $facade = new AnmeldungFacade();
        $items = $facade->findAppointments();

        self::assertEquals(
            [AvailableSlot::fromUrl('/terminvereinbarung/termin/time/1654207200/')],
            $items
        );

        $consolePrinter = new ConsolePrinter();
        $consolePrinter->print($items);

        $this->expectOutputString(
            "1 spots found\n1. Friday, 3rd Jun 2022. Click here for booking: https://service.berlin.de/terminvereinbarung/termin/time/1654207200/\n"
        );
    }
}
