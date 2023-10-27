<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Model\Reader;

use Generated\Shared\Transfer\PrinterProfileTransfer;
use Generated\Shared\Transfer\PrinterTransfer;

interface ReaderAdapterInterface
{
    /**
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function getProfile(): PrinterProfileTransfer;

    /**
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\ComputerTransfer>
     */
    public function getComputers(): array;

    /**
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\PrinterTransfer>
     */
    public function getPrinters(): array;

    /**
     * @param int $printerId
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return \Generated\Shared\Transfer\PrinterTransfer|null
     */
    public function getSinglePrinter(int $printerId): ?PrinterTransfer;

    /**
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return array<\Generated\Shared\Transfer\PrintJobTransfer>
     */
    public function getPrintJobs(): array;
}
