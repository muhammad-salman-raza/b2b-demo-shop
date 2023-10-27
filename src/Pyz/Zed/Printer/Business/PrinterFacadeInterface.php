<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Business;

use Generated\Shared\Transfer\PrinterProfileTransfer;
use Generated\Shared\Transfer\PrintRequestTransfer;

interface PrinterFacadeInterface
{
    /**
     * Specification:
     * - Returns profile information for Printer service
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function getProfile(): PrinterProfileTransfer;

    /**
     * Specification:
     * - Sends rquest to print
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @return bool
     */
    public function print(PrintRequestTransfer $printRequestTransfer): bool;
}
