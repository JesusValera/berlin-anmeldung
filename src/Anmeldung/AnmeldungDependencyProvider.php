<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractDependencyProvider;
use Gacela\Framework\Container\Container;
use JesusValera\Anmeldung\Infrastructure\WebClient;
use Symfony\Component\Panther;

final class AnmeldungDependencyProvider extends AbstractDependencyProvider
{
    public function provideModuleDependencies(Container $container): void
    {
        $container->set('client_panther', static fn () => new WebClient(Panther\Client::createFirefoxClient()));
    }
}
