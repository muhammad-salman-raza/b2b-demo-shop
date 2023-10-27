<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Shared\Printer;

interface PrinterConstants
{
    /**
     * Specification:
     * - PrintNode base url.
     *
     * @api
     *
     * @var string
     */
    public const PRINTNODE_BASE_URL = 'PRINTER:PRINTNODE_BASE_URL';

    /**
     * Specification:
     * - Printnode key
     *
     * @api
     *
     * @var string
     */
    public const PRINTNODE_KEY = 'PRINTER:PRINTNODE_KEY';
}
