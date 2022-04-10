<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther;

final class WebClient implements WebClientInterface
{
    public function __construct(private Panther\Client $client)
    {
    }

    public function getCurrentUrl(): string
    {
        return $this->client->getCurrentURL();
    }

    public function request(string $method, string $url): void
    {
        $this->client->request($method, $url);
    }

    public function clickLink(string $linkText): void
    {
        $this->client->clickLink($linkText);
    }

    public function waitForVisibility(string $locatorString): Crawler
    {
        return $this->client->waitForVisibility($locatorString);
    }
}
