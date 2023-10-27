<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Business;

use Pyz\Client\Printer\PrinterClientInterface;
use Pyz\Zed\Printer\PrinterDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\Printer\PrinterConfig getConfig()
 */
class PrinterBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Client\Printer\PrinterClientInterface
     */
    public function getPrinterClient(): PrinterClientInterface
    {
        return $this->getProvidedDependency(PrinterDependencyProvider::CLIENT_PRINTER);
    }
}
