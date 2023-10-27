<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Shared\Printer;

use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\AbstractSharedConfig;

class PrinterConfig extends AbstractSharedConfig
{
    /**
     * Base Url to connect printNode
     *
     * @api
     *
     * @return string
     */
    public function getPrintNodeBaseUrl(): string
    {
        return Config::getInstance()->get(PrinterConstants::PRINTNODE_BASE_URL);
    }

    /**
     * API Key for PrintNode
     *
     * @api
     *
     * @return string
     */
    public function getPrintNodeAPIKey(): string
    {
        return Config::getInstance()->get(PrinterConstants::PRINTNODE_KEY);
    }
}
