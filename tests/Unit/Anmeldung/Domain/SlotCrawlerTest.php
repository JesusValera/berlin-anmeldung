<?php

declare(strict_types=1);

namespace JesusValeraTest\Unit\Anmeldung\Domain;

use JesusValera\Anmeldung\Application\SearcherSlotCrawler;
use JesusValera\Anmeldung\Domain\ValueObject\Appointment;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use PHPUnit\Framework\TestCase;

final class SlotCrawlerTest extends TestCase
{
    public function test_search_slots_from_source_code_file(): void
    {
        $slotCrawler = new SearcherSlotCrawler(new FakeAppointmentClient());

        $actual = $slotCrawler->searchSlots();

        $appointment = Appointment::create('Bürgeramt Sonnenallee - Vorzugstermine', '/terminvereinbarung/termin/time/1661772240/2863/');
        $availableSlot = AvailableSlot::fromUrl('/terminvereinbarung/termin/time/1654207200/');
        $availableSlot->addAppointment($appointment);

        self::assertEquals([$availableSlot], $actual);
    }
}
