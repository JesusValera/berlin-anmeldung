<?php

declare(strict_types=1);

use Gacela\Framework\Config\GacelaConfigBuilder\MappingInterfacesBuilder;
use Gacela\Framework\Setup\SetupGacela;
use JesusValera\Anmeldung\Domain\CrawlerInterface;
use JesusValera\Anmeldung\Infrastructure\PantherCrawler;

return static fn () => (new SetupGacela())
    ->setMappingInterfaces(
        static function (MappingInterfacesBuilder $mappingInterfacesBuilder): void {
            $mappingInterfacesBuilder->bind(CrawlerInterface::class, PantherCrawler::class);
        }
    );
