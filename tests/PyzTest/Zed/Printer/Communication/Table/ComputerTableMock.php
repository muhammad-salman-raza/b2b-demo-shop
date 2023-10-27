<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Printer\Communication\Table;

use Pyz\Client\Printer\PrinterClientInterface;
use Pyz\Zed\Printer\Communication\Table\ComputerTable;
use Symfony\Component\HttpFoundation\Request;

class ComputerTableMock extends ComputerTable
{
    /**
     * @param \Pyz\Client\Printer\PrinterClientInterface $printerClient
     * @param string|null $searchTerm
     */
    public function __construct(private PrinterClientInterface $printerClient, private ?string $searchTerm = null)
    {
        parent::__construct($printerClient);
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
