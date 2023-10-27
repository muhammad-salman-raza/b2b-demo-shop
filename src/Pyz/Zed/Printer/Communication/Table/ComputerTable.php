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

class ComputerTable extends AbstractTable
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
    public const COL_HOSTNAME = 'hostname';

    /**
     * @var string
     */
    public const COL_STATE = 'state';

    /**
     * @var string
     */
    public const COL_INET = 'inet';

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
            self::COL_HOSTNAME => 'Hostname',
            self::COL_INET => 'Computer',
            self::COL_STATE => 'State',

        ]);
        $config->setOrdering(false);
        $config->setSearchable([]);
        $config->setPaging(false);
        $config->setUrl('computer-table');

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<string, mixed>
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $computers = $this->printerClient->getComputers();
        $this->total = count($computers);

        $filteredComputers = $this->filterComputersBySearchTerm($computers);

        $this->filtered = count($filteredComputers);

        return array_map(fn ($computer) => [
            self::COL_ID => $computer->getComputerId(),
            self::COL_NAME => $computer->getName(),
            self::COL_HOSTNAME => $computer->getHostname(),
            self::COL_INET => $computer->getInet(),
            self::COL_STATE => $computer->getState(),
        ], $filteredComputers);
    }

    /**
     * @param \Generated\Shared\Transfer\ComputerTransfer[] $computers
     *
     * @return \Generated\Shared\Transfer\ComputerTransfer[]
     */
    private function filterComputersBySearchTerm(array $computers): array
    {
        $searchTerm = $this->getSearchTerm();
        $searchValue = $searchTerm[static::PARAMETER_VALUE] ?? '';

        if (!$searchValue) {
            return $computers;
        }

        return array_filter(
            $computers,
            fn ($computer) => str_contains((string)$computer->getComputerId(), $searchValue) ||
                str_contains($computer->getName(), $searchValue) ||
                str_contains($computer->getHostname(), $searchValue) ||
                str_contains($computer->getInet(), $searchValue) ||
                str_contains($computer->getState(), $searchValue)
        );
    }
}
