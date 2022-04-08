<?php

declare(strict_types=1);

namespace JesusValeraTest\Integration;

use DOMElement;
use JesusValera\Anmeldung\Domain\CrawlerInterface;
use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;
use Symfony\Component\DomCrawler\Crawler;

final class FakeCrawler implements CrawlerInterface
{
    /** @var list<AvailableSlot> */
    private array $items = [];

    public function searchSlots(): array
    {
        $html = $this->staticHtmlResponse();
        $symfonyCrawler = new Crawler($html);

        $bookableDays = $symfonyCrawler->filter('.calendar-table .row-fluid .buchbar');
        /** @var DOMElement $bookableDay */
        foreach ($bookableDays as $bookableDay) {
            /** @var DOMElement $childElement */
            $childElement = $bookableDay->childNodes->item(0);
            /** @var array{href:string,title:string} $allAttributes */
            $allAttributes = array_map(
                static fn (object $att): object => $att,
                iterator_to_array($childElement->attributes->getIterator())
            );

            $href = $allAttributes['href'];
            $this->items[] = AvailableSlot::fromUrl($href->value);
        }

        return $this->items;
    }

    private function staticHtmlResponse(): string
    {
        return file_get_contents(__DIR__ . '/source-code.html');
    }
}
