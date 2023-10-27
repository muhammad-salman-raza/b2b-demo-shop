<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Adapter\Printnode\Hydrator;

use Generated\Shared\Transfer\PrinterTransfer;

class PrinterHydrator
{
    /**
     * @param \Pyz\Client\Printer\Adapter\Printnode\Hydrator\ComputerHydrator $computerHydrator
     */
    public function __construct(private ComputerHydrator $computerHydrator)
    {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Generated\Shared\Transfer\PrinterTransfer
     */
    public function hydrate(array $data): PrinterTransfer
    {
        $printerTransfer = (new PrinterTransfer())
            ->fromArray($data, true);

        if (isset($data['id'])) {
            $printerTransfer->setPrinterId($data['id']);
        }

        if (isset($data['computer'])) {
            $printerTransfer->setComputer($this->computerHydrator->hydrate($data['computer']));
        }

        return $printerTransfer;
    }
}
