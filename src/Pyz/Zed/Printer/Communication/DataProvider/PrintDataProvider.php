<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Communication\DataProvider;

use Generated\Shared\Transfer\PrintRequestTransfer;
use Pyz\Client\Printer\PrinterClientInterface;

class PrintDataProvider
{
    /**
     * @param \Pyz\Client\Printer\PrinterClientInterface $printerClient
     */
    public function __construct(
        private PrinterClientInterface $printerClient
    ) {
    }

    /**
     * @return \Generated\Shared\Transfer\PrintRequestTransfer
     */
    public function getData(): PrintRequestTransfer
    {
        $printRequest = (new PrintRequestTransfer())
            ->setQty(1)
            ->setContentType('pdf_base64')
            ->setSource('Zed');

        return $printRequest;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        $printers = $this->printerClient->getPrinters();

        return [
            'printers' => $printers,
        ];
    }
}
