<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Printer\Communication\Table;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ComputerTransfer;
use Generated\Shared\Transfer\PrinterTransfer;
use Pyz\Client\Printer\PrinterClientInterface;

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
class PrinterTableTest extends Unit
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
    public function testFetchDataShouldReturnPrinters(): void
    {
        $printersData = [
            [
                'printerId' => 1,
                'computer' => [
                    'computerId' => 2,
                    'name' => 'Test Name 2',
                    'hostname' => 'Host Name 2',
                    'inet' => '192.168.1.2',
                    'state' => 'offline',
                ],
                'default' => true,
                'name' => 'Test Printer 1',
                'description' => 'Test description 1',
                'state' => 'online',
            ],
            [
                'printerId' => 2,
                'computer' => [
                    'computerId' => 2,
                    'name' => 'Test Name 2',
                    'hostname' => 'Host Name 2',
                    'inet' => '192.168.1.2',
                    'state' => 'offline',
                ],
                'default' => false,
                'name' => 'Test Printer 2',
                'description' => 'Test description 2',
                'state' => 'offline',
            ],
        ];

        $printerTableMock = $this->createPrinterTableMock($printersData);

        // Act
        $result = $printerTableMock->fetchData();

        // Assert
        $expectedPrinterTableData = [
            $this->buildExpectedRow(1,'Test Printer 1', 'Test Name 2', 'Test description 1', 'Yes', 'online'),
            $this->buildExpectedRow(2,'Test Printer 2', 'Test Name 2', 'Test description 2', 'No', 'offline'),
        ];

        $this->assertEquals(2, $result['recordsTotal']);
        $this->assertEquals(2, $result['recordsFiltered']);
        $this->assertEqualsCanonicalizing($expectedPrinterTableData, $result['data']);
    }

    /**
     * @return void
     */
    public function testFetchDataShouldReturnComputersWithFilteredResult(): void
    {
        $printersData = [
            [
                'printerId' => 1,
                'computer' => [
                    'computerId' => 2,
                    'name' => 'Test Name 2',
                    'hostname' => 'Host Name 2',
                    'inet' => '192.168.1.2',
                    'state' => 'offline',
                ],
                'default' => true,
                'name' => 'Test Printer 1',
                'description' => 'Test description 1',
                'state' => 'online',
            ],
            [
                'printerId' => 2,
                'computer' => [
                    'computerId' => 2,
                    'name' => 'Test Name 2',
                    'hostname' => 'Host Name 2',
                    'inet' => '192.168.1.2',
                    'state' => 'offline',
                ],
                'default' => true,
                'name' => 'Test Printer 2',
                'description' => 'Test description 2',
                'state' => 'offline',
            ],
        ];

        $printerTableMock = $this->createPrinterTableMock($printersData, 'Printer 1');

        // Act
        $result = $printerTableMock->fetchData();

        // Assert
        $expectedPrinterTableData = [
            $this->buildExpectedRow(1,'Test Printer 1', 'Test Name 2', 'Test description 1', 'Yes', 'online'),
        ];

        $this->assertEquals(2, $result['recordsTotal']);
        $this->assertEquals(1, $result['recordsFiltered']);
        $this->assertEqualsCanonicalizing($expectedPrinterTableData, $result['data']);
    }

    /**
     * @param array<int, array<string, mixed>> $printersData
     * @param string|null $searchTerm
     *
     * @return \PyzTest\Zed\Printer\Communication\Table\PrinterTableMock
     */
    protected function createPrinterTableMock(array $printersData, ?string $searchTerm = null): PrinterTableMock
    {
        $printerTransfers = [];

        foreach ($printersData as $data) {
            $printerTransfers[] = (new PrinterTransfer())
                ->fromArray($data, true);
        }


        $printerClientMock = $this->getMockBuilder(PrinterClientInterface::class)
            ->getMock();
        $printerClientMock->method('getPrinters')
            ->willReturn($printerTransfers);

        return new PrinterTableMock(
            $printerClientMock,
            $searchTerm,
        );
    }

    /**
     * @param int $idPrinter
     * @param string $printerName
     * @param string $computerName
     * @param string $description
     * @param string $default
     * @param string $state
     *
     * @return array
     */
    protected function buildExpectedRow(int $idPrinter, string $printerName, string $computerName, string $description, string $default, string $state): array
    {
        return [
            PrinterTableMock::COL_ID => $idPrinter,
            PrinterTableMock::COL_NAME => $printerName,
            PrinterTableMock::COL_COMPUTER => $computerName,
            PrinterTableMock::COL_DESCRIPTION => $description,
            PrinterTableMock::COL_DEFAULT => $default,
            PrinterTableMock::COL_STATE => $state,
        ];
    }
}
