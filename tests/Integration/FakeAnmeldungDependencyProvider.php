<?php

declare(strict_types=1);

namespace JesusValeraTest\Integration;

use Gacela\Framework\AbstractDependencyProvider;
use Gacela\Framework\Container\Container;
use JesusValera\Anmeldung\Infrastructure\WebClientInterface;

final class FakeAnmeldungDependencyProvider extends AbstractDependencyProvider
{
    public function __construct(private WebClientInterface $webClient)
    {
    }

    public function provideModuleDependencies(Container $container): void
    {
        $container->set('client_panther', fn () => $this->webClient);
    }
}
