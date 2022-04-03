<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractConfig;

final class AnmeldungConfig extends AbstractConfig
{
    public function getName(): string
    {
        return $this->get('name');
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }

    public function getDetails(): string
    {
        return $this->get('details');
    }
}
