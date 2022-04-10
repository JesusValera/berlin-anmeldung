<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure;

use Symfony\Component\DomCrawler\Crawler;

interface WebClientInterface
{
    public function getCurrentUrl(): string;

    public function request(string $method, string $url): void;

    public function clickLink(string $linkText): void;

    public function waitForVisibility(string $locatorString): Crawler;
}
