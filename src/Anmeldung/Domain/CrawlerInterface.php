<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Domain;

interface CrawlerInterface
{
    public function searchSlots(): array;
}
