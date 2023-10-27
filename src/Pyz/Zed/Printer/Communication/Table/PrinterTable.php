<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Communication\Table;

use Pyz\Client\Printer\PrinterClientInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class PrinterTable extends AbstractTable
{
    /**
     * @var string
     */
    public const COL_ID = 'id';

    /**
     * @var string
     */
    public const COL_NAME = 'name';

    /**
     * @var string
     */
    public const COL_DESCRIPTION = 'description';

    /**
     * @var string
     */
    public const COL_DEFAULT = 'default';

    /**
     * @var string
     */
    public const COL_STATE = 'state';

    /**
     * @var string
     */
    public const COL_COMPUTER = 'computer';

    /**
     * @param \Pyz\Client\Printer\PrinterClientInterface $printerClient
     */
    public function __construct(
        private PrinterClientInterface $printerClient
    ) {
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            self::COL_ID => 'ID',
            self::COL_NAME => 'Name',
            self::COL_DESCRIPTION => 'Description',
            self::COL_COMPUTER => 'Computer',
            self::COL_DEFAULT => 'Default',
            self::COL_STATE => 'State',

        ]);
        $config->setOrdering(false);
        $config->setSearchable([]);
        $config->setPaging(false);
        $config->setUrl('printer-table');

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<string, mixed>
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $printers = $this->printerClient->getPrinters();
        $this->total = count($printers);
        $filteredPrinters = $this->filterPrintersBySearchTerm($printers);

        $this->filtered = count($filteredPrinters);

        return array_map(fn ($printer) => [
            self::COL_ID => $printer->getPrinterId(),
            self::COL_NAME => $printer->getName(),
            self::COL_COMPUTER => $printer->getComputer()?->getName(),
            self::COL_DESCRIPTION => $printer->getDescription(),
            self::COL_DEFAULT => $this->renderBooleanColumn($printer->getDefault() ?? false),
            self::COL_STATE => $printer->getState(),
        ], $filteredPrinters);
    }

    /**
     * @param bool $value
     *
     * @return string
     */
    protected function renderBooleanColumn(bool $value): string
    {
        return $value ? 'Yes' : 'No';
    }

    /**
     * @param \Generated\Shared\Transfer\PrinterTransfer[] $printers
     *
     * @return \Generated\Shared\Transfer\PrinterTransfer[]
     */
    private function filterPrintersBySearchTerm(array $printers): array
    {
        $searchTerm = $this->getSearchTerm();
        $searchValue = $searchTerm[static::PARAMETER_VALUE] ?? '';

        if (!$searchValue) {
            return $printers;
        }

        return array_filter(
            $printers,
            fn ($printer) => str_contains((string)$printer->getPrinterId(), $searchValue) ||
                str_contains($printer->getName(), $searchValue) ||
                str_contains($printer->getComputer()?->getName(), $searchValue) ||
                str_contains($printer->getDescription(), $searchValue) ||
                str_contains($printer->getState(), $searchValue)
        );
    }
}
