<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Domain\Exceptions;

final class NoSuchElementException extends \Facebook\WebDriver\Exception\NoSuchElementException
{
    public function __construct(string $currentUrl)
    {
        parent::__construct(
            sprintf("There was an error when fetching data from URL %s\n", $currentUrl)
        );
    }
}
