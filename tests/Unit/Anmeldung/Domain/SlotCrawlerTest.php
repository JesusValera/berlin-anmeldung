<?php

declare(strict_types=1);

namespace JesusValeraTest\Unit\Anmeldung\Domain;

use JesusValera\Anmeldung\Domain\SlotCrawler;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use PHPUnit\Framework\TestCase;

final class SlotCrawlerTest extends TestCase
{
    /** @test */
    public function search_slots_from_source_code_file(): void
    {
        $slotCrawler = new SlotCrawler(new FakeAppointmentClient());
        $availableSlots = $slotCrawler->searchSlots();

        self::assertEquals(
            [
                AvailableSlot::fromUrl('/terminvereinbarung/termin/time/1654207200/'),
            ],
            $availableSlots
        );
    }
}
