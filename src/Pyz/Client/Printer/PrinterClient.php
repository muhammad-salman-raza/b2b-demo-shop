<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer;

use Generated\Shared\Transfer\PrinterProfileTransfer;
use Generated\Shared\Transfer\PrinterTransfer;
use Generated\Shared\Transfer\PrintRequestTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\Printer\PrinterFactory getFactory()
 */
class PrinterClient extends AbstractClient implements PrinterClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function getProfile(): PrinterProfileTransfer
    {
        return $this->getFactory()
            ->getReader()
            ->getProfile();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\ComputerTransfer>
     */
    public function getComputers(): array
    {
        return $this->getFactory()
            ->getReader()
            ->getComputers();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\PrinterTransfer>
     */
    public function getPrinters(): array
    {
        return $this->getFactory()
            ->getReader()
            ->getPrinters();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\PrintJobTransfer>
     */
    public function getPrintJobs(): array
    {
        return $this->getFactory()
            ->getReader()
            ->getPrintJobs();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return \Generated\Shared\Transfer\PrinterTransfer
     */
    public function getDefaultPrinter(): PrinterTransfer
    {
        return $this->getFactory()
            ->getReader()
            ->getDefaultPrinter();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return bool
     */
    public function print(PrintRequestTransfer $printRequestTransfer): bool
    {
        return $this->getFactory()
            ->createPrinter()
            ->print($printRequestTransfer);
    }
}
