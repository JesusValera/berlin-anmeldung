<?php

declare(strict_types=1);

namespace JesusValera\Anmeldung\Infrastructure\IO;

use JesusValera\Anmeldung\Domain\ValueObject\AvailableSlot;

use function count;

final class ConsolePrinter
{
    /**
     * @param array{name:string,email:string, details:string} $config
     */
    public function __construct(
        private array $config
    ) {
    }

    public function print(array $availableSlots): void
    {
        $this->printHeader();
        $this->printBody($availableSlots);
    }

    private function printHeader(): void
    {
        if (!empty($this->config['name']) && !empty($this->config['email']) && !empty($this->config['details'])) {
            $output = <<<TXT
This data will be used in the form
==================================
- Name: “%s”
- Email: “%s”
- Details: “%s”
==================================

TXT;
            echo sprintf($output, $this->config['name'], $this->config['email'], $this->config['details']);
        }

        echo 'Checking for available spots . . .' . PHP_EOL;
    }

    private function printBody(array $availableSlots): void
    {
        if (empty($availableSlots)) {
            echo 'No spots found, try again in another moment' . PHP_EOL;
            return;
        }

        echo count($availableSlots) . ' spots found' . PHP_EOL;

        /** @var AvailableSlot[] $availableSlots */
        foreach ($availableSlots as $key => $availableSlot) {
            echo sprintf(
                '%d. %s. Click here for booking: %s' . PHP_EOL,
                ((int) $key + 1),
                $availableSlot->getDateTimeFormat(),
                $availableSlot->getUrl()
            );
        }
    }
}
