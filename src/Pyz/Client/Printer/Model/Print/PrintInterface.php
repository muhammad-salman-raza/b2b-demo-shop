<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Model\Print;

use Generated\Shared\Transfer\PrintRequestTransfer;

interface PrintInterface
{
    /**
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterConnectionException
     *
     * @return bool
     */
    public function print(PrintRequestTransfer $printRequestTransfer): bool;
}
