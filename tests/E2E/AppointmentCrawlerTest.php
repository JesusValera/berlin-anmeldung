<?php

declare(strict_types=1);

namespace JesusValeraTest\E2E;

use JesusValera\Anmeldung\AnmeldungFacade;
use PHPUnit\Framework\TestCase;

final class AppointmentCrawlerTest extends TestCase
{
    public function test_page_is_readable(): void
    {
        $facade = new AnmeldungFacade();

        $content = $facade->findAppointments();

        self::assertIsArray($content);
    }
}
