<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Model\Print;

use Generated\Shared\Transfer\PrintRequestTransfer;
use Pyz\Client\Printer\Exception\PrinterNotFoundException;
use Pyz\Client\Printer\Model\Reader\ReaderInterface;

class Printer implements PrintInterface
{
    /**
     * @param \Pyz\Client\Printer\Model\Reader\ReaderInterface $reader
     * @param \Pyz\Client\Printer\Model\Print\PrintAdapterInterface $adapter
     */
    public function __construct(
        private ReaderInterface $reader,
        private PrintAdapterInterface $adapter
    ) {
    }

    /**
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @return bool
     */
    public function print(PrintRequestTransfer $printRequestTransfer): bool
    {
        $printRequestTransfer = $this->confirmPrinterIsAvailable($printRequestTransfer);

        return $this->adapter->print($printRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterNotFoundException
     *
     * @return \Generated\Shared\Transfer\PrintRequestTransfer
     */
    private function confirmPrinterIsAvailable(PrintRequestTransfer $printRequestTransfer): PrintRequestTransfer
    {
        if ($printRequestTransfer->getPrinter() === null || $printRequestTransfer->getPrinter()->getPrinterId() === null) {
            $printRequestTransfer->setPrinter($this->reader->getDefaultPrinter());

            return $printRequestTransfer;
        }

        $printer = $this->reader->getSinglePrinter($printRequestTransfer->getPrinter()->getPrinterId());

        if ($printer === null) {
            throw new PrinterNotFoundException('Requested printer is not avaialble.');
        }

        return $printRequestTransfer;
    }
}
