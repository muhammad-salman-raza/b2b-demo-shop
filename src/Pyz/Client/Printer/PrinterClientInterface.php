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

/**
 * @method \Pyz\Client\Printer\PrinterFactory getFactory()
 */
interface PrinterClientInterface
{
    /**
     * Specification:
     * - Returns Profile for Printer Service Profile
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function getProfile(): PrinterProfileTransfer;

    /**
     * Specification:
     * - Returns connected computers
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\ComputerTransfer>
     */
    public function getComputers(): array;

    /**
     * Specification:
     * - Returns connected printers
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\PrinterTransfer>
     */
    public function getPrinters(): array;

    /**
     * Specification:
     * - Returns print jobs
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\PrintJobTransfer>
     */
    public function getPrintJobs(): array;

    /**
     * Specification:
     * - Sends document to requested printer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return bool
     */
    public function print(PrintRequestTransfer $printRequestTransfer): bool;

    /**
     * Specification:
     * - Returns default printer
     *
     * @api
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return \Generated\Shared\Transfer\PrinterTransfer
     */
    public function getDefaultPrinter(): PrinterTransfer;
}
