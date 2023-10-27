<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Model\Reader;

use Generated\Shared\Transfer\PrinterProfileTransfer;
use Generated\Shared\Transfer\PrinterTransfer;

class Reader implements ReaderInterface
{
    /**
     * @param \Pyz\Client\Printer\Model\Reader\ReaderAdapterInterface $adapter
     */
    public function __construct(private ReaderAdapterInterface $adapter)
    {
    }

    /**
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function getProfile(): PrinterProfileTransfer
    {
        return $this->adapter->getProfile();
    }

    /**
     * @return array<\Generated\Shared\Transfer\ComputerTransfer>
     */
    public function getComputers(): array
    {
        return $this->adapter->getComputers();
    }

    /**
     * @return array<\Generated\Shared\Transfer\PrinterTransfer>
     */
    public function getPrinters(): array
    {
        return $this->adapter->getPrinters();
    }

    /**
     * @return array<\Generated\Shared\Transfer\PrintJobTransfer>
     */
    public function getPrintJobs(): array
    {
        return $this->adapter->getPrintJobs();
    }

    /**
     * @return \Generated\Shared\Transfer\PrinterTransfer
     */
    public function getDefaultPrinter(): PrinterTransfer
    {
        $printers = $this->getPrinters();

        foreach ($printers as $printer) {
            if ($printer->getDefault()) {
                return $printer;
            }
        }

        return $printers[0];
    }

    /**
     * @param int $printerId
     *
     * @return \Generated\Shared\Transfer\PrinterTransfer|null
     */
    public function getSinglePrinter(int $printerId): ?PrinterTransfer
    {
        return $this->adapter->getSinglePrinter($printerId);
    }
}
