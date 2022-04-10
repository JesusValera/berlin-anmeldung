<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractDependencyProvider;
use Gacela\Framework\Container\Container;
use Symfony\Component\Panther;

/**
 * @method AnmeldungConfig getConfig()
 */
final class AnmeldungDependencyProvider extends AbstractDependencyProvider
{
    public function provideModuleDependencies(Container $container): void
    {
        $container->set('client_panther', static fn () => Panther\Client::createFirefoxClient());
    }
}
