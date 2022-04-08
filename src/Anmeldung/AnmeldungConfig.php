<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractConfig;

final class AnmeldungConfig extends AbstractConfig
{
    public function getName(): string
    {
        /** @var string $name */
        $name = $this->get('name');

        return $name;
    }

    public function getEmail(): string
    {
        /** @var string $email */
        $email = $this->get('email');

        return $email;
    }

    public function getDetails(): string
    {
        /** @var string $details */
        $details = $this->get('details');

        return $details;
    }
}
