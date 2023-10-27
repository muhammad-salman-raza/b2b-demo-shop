<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Printer\Communication\Table;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ComputerTransfer;
use Generated\Shared\Transfer\PrinterTransfer;
use Generated\Shared\Transfer\PrintJobTransfer;
use Pyz\Client\Printer\PrinterClientInterface;
use Pyz\Zed\Printer\Communication\Table\PrintJobTable;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Printer
 * @group Communication
 * @group Table
 * @group PrinterTableTest
 * Add your own group annotations below this line
 */
class PrintJobTableTest extends Unit
{
 /**
  * @return void
  */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return void
     */
    public function testFetchDataShouldReturnPrintjobs(): void
    {
        $printJobData = [
            [
                'printjobId' => 1,
                'title' => 'Test title 1',
                'source' => 'zed',
                'state' => 'new',
                'createTimestamp' => '2023-10-01T12:45:55',
                'expireAt' => '2023-11-01T12:45:55',
            ],
            [
                'printjobId' => 2,
                'title' => 'Test title 2',
                'source' => 'test',
                'state' => 'done',
                'createTimestamp' => '2023-10-01T12:45:55',
                'expireAt' => '2023-11-01T12:45:55',
            ],
        ];

        $printerJobTableMock = $this->createPrintJobTableMock($printJobData);

        // Act
        $result = $printerJobTableMock->fetchData();

        // Assert
        $expectedPrintjobTableData = [
            $this->buildExpectedRow(1,'Test title 1', 'zed', 'new'),
            $this->buildExpectedRow(2,'Test title 2', 'test', 'done'),
        ];

        $this->assertEquals(2, $result['recordsTotal']);
        $this->assertEquals(2, $result['recordsFiltered']);
        $this->assertEqualsCanonicalizing($expectedPrintjobTableData, $result['data']);
    }

    /**
     * @return void
     */
    public function testFetchDataShouldReturnPrintJobsWithFilteredResult(): void
    {
        $printJobData = [
            [
                'printjobId' => 1,
                'title' => 'Test title 1',
                'source' => 'zed',
                'state' => 'new',
                'createTimestamp' => '2023-10-01T12:45:55',
                'expireAt' => '2023-11-01T12:45:55',
            ],
            [
                'printjobId' => 2,
                'title' => 'Test title 2',
                'source' => 'test',
                'state' => 'done',
                'createTimestamp' => '2023-10-01T12:45:55',
                'expireAt' => '2023-11-01T12:45:55',
            ],
        ];

        $printerJobTableMock = $this->createPrintJobTableMock($printJobData, 'zed');

        // Act
        $result = $printerJobTableMock->fetchData();

        // Assert
        $expectedPrintjobTableData = [
            $this->buildExpectedRow(1,'Test title 1', 'zed', 'new'),
        ];

        $this->assertEquals(2, $result['recordsTotal']);
        $this->assertEquals(1, $result['recordsFiltered']);
        $this->assertEqualsCanonicalizing($expectedPrintjobTableData, $result['data']);
    }

    /**
     * @param array<int, array<string, mixed>> $printersData
     * @param string|null $searchTerm
     *
     * @return \PyzTest\Zed\Printer\Communication\Table\PrintJobTableMock
     */
    protected function createPrintJobTableMock(array $printJobData, ?string $searchTerm = null): PrintJobTableMock
    {
        $printJobTransfers = [];

        foreach ($printJobData as $data) {
            $data['printer'] = [
                'printerId' => 1,
                'name' => 'test printer',
                'computer' => [
                    'computerId' => 4,
                    'name' => 'computer name'
                ]
            ];

            $printJobTransfers[] = (new PrintJobTransfer())
                ->fromArray($data, true);
        }


        $printerClientMock = $this->getMockBuilder(PrinterClientInterface::class)
            ->getMock();
        $printerClientMock->method('getPrintJobs')
            ->willReturn($printJobTransfers);

        $dateTimeService = $this->getMockBuilder(UtilDateTimeServiceInterface::class)
            ->getMock();
        $dateTimeService->method('formatDate')
            ->willReturn('formatted date');

        return new PrintJobTableMock(
            $printerClientMock,
            $dateTimeService,
            $searchTerm,
        );
    }

    /**
     * @param int $idPrintJob
     * @param string $printJobTitle
     * @param string $source
     * @param string $state
     *
     * @return array
     */
    protected function buildExpectedRow(int $idPrintJob, string $printJobTitle, string $source, string $state): array
    {
        return [
            PrintJobTableMock::COL_ID => $idPrintJob,
            PrintJobTableMock::COL_TITLE => $printJobTitle,
            PrintJobTableMock::COL_SOURCE => $source,
            PrintJobTableMock::COL_PRINTER => 'test printer',
            PrintJobTableMock::COL_COMPUTER => 'computer name',
            PrintJobTableMock::COL_STATE => $state,
            PrintJobTableMock::COL_CREATED => 'formatted date',
            PrintJobTableMock::COL_EXPIRED => 'formatted date',
        ];
    }
}
