<?php

declare(strict_types=1);

namespace JesusValeraTest\E2E;

use JesusValera\Anmeldung\Infrastructure\PantherCrawler;
use PHPUnit\Framework\TestCase;

final class SimpleTest extends TestCase
{
    /**
     * @test
     */
    public function page_is_readable(): void
    {
        $symfonyCrawler = new PantherCrawler();
        $content = $symfonyCrawler->searchSlots();

        self::assertIsArray($content);
    }
}
