<?php

declare(strict_types=1);

namespace JesusValeraTest\Integration;

use Gacela\Framework\ClassResolver\GlobalInstance\AnonymousGlobal;
use JesusValera\Anmeldung\AnmeldungFacade;
use JesusValera\Anmeldung\AnmeldungFactory;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use JesusValera\Anmeldung\Infrastructure\AppointmentClientInterface;
use JesusValeraTest\Unit\Anmeldung\Domain\FakeAppointmentClient;
use PHPUnit\Framework\TestCase;

final class AppointmentCrawlerTest extends TestCase
{
    /**
     * @test
     */
    public function page_is_readable(): void
    {
        AnonymousGlobal::overrideExistingResolvedClass(
            AnmeldungFactory::class,
            new class () extends AnmeldungFactory {
                protected function createAppointmentClient(): AppointmentClientInterface
                {
                    return new FakeAppointmentClient();
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
}
