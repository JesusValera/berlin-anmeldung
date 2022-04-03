<?php

declare(strict_types=1);

namespace JesusValeraTest\Unit;

use JesusValera\Anmeldung\Infrastructure\PantherCrawler;
use PHPUnit\Framework\TestCase;

final class SimpleTest extends TestCase
{
    public function test_true(): void
    {
        $symfonyCrawler = new PantherCrawler();
        $content = $symfonyCrawler->searchSlots();

        self::assertTrue(true);
    }
}
