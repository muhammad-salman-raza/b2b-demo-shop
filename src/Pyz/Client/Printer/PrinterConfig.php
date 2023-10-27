<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer;

use Spryker\Client\Kernel\AbstractBundleConfig;

/**
 * @method \Pyz\Shared\Printer\PrinterConfig getSharedConfig()
 */
class PrinterConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getPrintNodeBaseUrl(): string
    {
        return $this->getSharedConfig()->getPrintNodeBaseUrl();
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPrintNodeAPIKey(): string
    {
        return $this->getSharedConfig()->getPrintNodeAPIKey();
    }
}
