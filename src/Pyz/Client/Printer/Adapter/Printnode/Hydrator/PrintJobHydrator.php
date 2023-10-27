<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Adapter\Printnode\Hydrator;

use Generated\Shared\Transfer\PrintJobTransfer;

class PrintJobHydrator
{
    /**
     * @param \Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrinterHydrator $printerHydrator
     */
    public function __construct(private PrinterHydrator $printerHydrator)
    {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Generated\Shared\Transfer\PrintJobTransfer
     */
    public function hydrate(array $data): PrintJobTransfer
    {
        $printJobTransfer = (new PrintJobTransfer())
            ->fromArray($data, true);

        if (isset($data['id'])) {
            $printJobTransfer->setPrintjobId($data['id']);
        }

        if (isset($data['printer'])) {
            $printJobTransfer->setPrinter($this->printerHydrator->hydrate($data['printer']));
        }

        return $printJobTransfer;
    }
}
