<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Communication\Table;

use Pyz\Client\Printer\PrinterClientInterface;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class PrintJobTable extends AbstractTable
{
    /**
     * @var string
     */
    public const COL_ID = 'id';

    /**
     * @var string
     */
    public const COL_TITLE = 'title';

    /**
     * @var string
     */
    public const COL_SOURCE = 'source';

    /**
     * @var string
     */
    public const COL_PRINTER = 'printer';

    /**
     * @var string
     */
    public const COL_STATE = 'state';

    /**
     * @var string
     */
    public const COL_COMPUTER = 'computer';

    /**
     * @var string
     */
    public const COL_CREATED = 'created';

    /**
     * @var string
     */
    public const COL_EXPIRED = 'expired';

    /**
     * @param \Pyz\Client\Printer\PrinterClientInterface $printerClient
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $utilDateTimeService
     */
    public function __construct(
        private PrinterClientInterface $printerClient,
        private UtilDateTimeServiceInterface $utilDateTimeService
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
            self::COL_TITLE => 'Title',
            self::COL_SOURCE => 'Source',
            self::COL_PRINTER => 'Printer',
            self::COL_COMPUTER => 'Computer',
            self::COL_STATE => 'State',
            self::COL_CREATED => 'Created At',
            self::COL_EXPIRED => 'Expired At',
        ]);

        $config->setOrdering(false);
        $config->setSearchable([]);
        $config->setPaging(false);
        $config->setUrl('printjob-table');

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<string, mixed>
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $printJobs = $this->printerClient->getPrintJobs();
        $this->total = count($printJobs);
        $filteredPrintJobs = $this->filterPrintJobsBySearchTerm($printJobs);

        $this->filtered = count($filteredPrintJobs);

        return array_map(fn ($printJob) => [
            self::COL_ID => $printJob->getPrintjobId(),
            self::COL_TITLE => $printJob->getTitle(),
            self::COL_SOURCE => $printJob->getSource(),
            self::COL_PRINTER => $printJob->getPrinter()?->getName(),
            self::COL_COMPUTER => $printJob->getPrinter()?->getComputer()?->getName(),
            self::COL_STATE => $printJob->getState(),
            self::COL_CREATED => $printJob->getCreateTimestamp()
                ? $this->utilDateTimeService->formatDate($printJob->getCreateTimestamp())
                : '',
            self::COL_EXPIRED => $printJob->getExpireAt()
                ? $this->utilDateTimeService->formatDate($printJob->getExpireAt())
                : '',
        ], $filteredPrintJobs);
    }

    /**
     * @param \Generated\Shared\Transfer\PrintJobTransfer[] $printJobs
     *
     * @return \Generated\Shared\Transfer\PrintJobTransfer[]
     */
    private function filterPrintJobsBySearchTerm(array $printJobs): array
    {
        $searchTerm = $this->getSearchTerm();
        $searchValue = $searchTerm[static::PARAMETER_VALUE] ?? '';

        if (!$searchValue) {
            return $printJobs;
        }

        return array_filter(
            $printJobs,
            fn ($printJob) => str_contains((string)$printJob->getPrintjobId(), $searchValue) ||
                str_contains($printJob->getTitle(), $searchValue) ||
                str_contains($printJob->getSource(), $searchValue) ||
                str_contains($printJob->getPrinter()?->getName(), $searchValue) ||
                str_contains($printJob->getPrinter()?->getComputer()?->getName(), $searchValue) ||
                str_contains($printJob->getState(), $searchValue)
        );
    }
}
