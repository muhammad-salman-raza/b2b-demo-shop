<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Printer\Communication\Table;

use Pyz\Client\Printer\PrinterClientInterface;
use Pyz\Zed\Printer\Communication\Table\PrintJobTable;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class PrintJobTableMock extends PrintJobTable
{
    /**
     * @param \Pyz\Client\Printer\PrinterClientInterface $printerClient
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $printerClient
     * @param string|null $searchTerm
     */
    public function __construct(private PrinterClientInterface $printerClient, UtilDateTimeServiceInterface $dateTimeService, private ?string $searchTerm = null)
    {
        parent::__construct($printerClient, $dateTimeService);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest(): Request
    {
        $query = [];
        if ($this->searchTerm) {
            $query = ['search' => ['value' => $this->searchTerm]];
        }

        return new Request($query);
    }
}
