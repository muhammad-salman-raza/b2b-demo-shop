<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Business;

use Generated\Shared\Transfer\PrinterProfileTransfer;
use Generated\Shared\Transfer\PrintRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Printer\Business\PrinterBusinessFactory getFactory()
 */
class PrinterFacade extends AbstractFacade implements PrinterFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function getProfile(): PrinterProfileTransfer
    {
        return $this->getFactory()->getPrinterClient()->getProfile();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @return bool
     */
    public function print(PrintRequestTransfer $printRequestTransfer): bool
    {
        return $this->getFactory()->getPrinterClient()->print($printRequestTransfer);
    }
}
