<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung;

use Gacela\Framework\AbstractConfig;

final class AnmeldungConfig extends AbstractConfig
{
    /**
     * @return array{name:string,email:string,details:string}
     */
    public function getOptions(): array
    {
        return [
            'name' => (string) $this->get('name'),
            'email' => (string) $this->get('email'),
            'details' => (string) $this->get('details'),
        ];
    }
}
