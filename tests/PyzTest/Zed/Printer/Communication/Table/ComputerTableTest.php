<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Printer\Communication\Table;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ComputerTransfer;
use Pyz\Client\Printer\PrinterClientInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Printer
 * @group Communication
 * @group Table
 * @group ComputerTableTest
 * Add your own group annotations below this line
 */
class ComputerTableTest extends Unit
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
    public function testFetchDataShouldReturnComputers(): void
    {
        $computersData = [
            [
                'computerId' => 1,
                'name' => 'Test Name 1',
                'hostname' => 'Host Name 1',
                'inet' => '192.168.1.1',
                'state' => 'online',
            ],
            [
                'computerId' => 2,
                'name' => 'Test Name 2',
                'hostname' => 'Host Name 2',
                'inet' => '192.168.1.2',
                'state' => 'offline',
            ],
        ];

        $computerTableMock = $this->createComputerTableMock($computersData);

        // Act
        $result = $computerTableMock->fetchData();

        // Assert
        $expectedComputerTableData = [
            $this->buildExpectedRow(1, 'Test Name 1', 'Host Name 1', '192.168.1.1', 'online'),
            $this->buildExpectedRow(2, 'Test Name 2', 'Host Name 2', '192.168.1.2', 'offline'),
        ];

        $this->assertEquals(2, $result['recordsTotal']);
        $this->assertEquals(2, $result['recordsFiltered']);
        $this->assertEqualsCanonicalizing($expectedComputerTableData, $result['data']);
    }

    /**
     * @return void
     */
    public function testFetchDataShouldReturnComputersWithFilteredResult(): void
    {
        $computersData = [
            [
                'computerId' => 1,
                'name' => 'Test Name 1',
                'hostname' => 'Host Name 1',
                'inet' => '192.168.1.1',
                'state' => 'online',
            ],
            [
                'computerId' => 2,
                'name' => 'Test Name 2',
                'hostname' => 'Host Name 2',
                'inet' => '192.168.1.2',
                'state' => 'offline',
            ],
        ];

        $computerTableMock = $this->createComputerTableMock($computersData, 'Name 2');

        // Act
        $result = $computerTableMock->fetchData();

        // Assert
        $expectedComputerTableData = [
            $this->buildExpectedRow(2, 'Test Name 2', 'Host Name 2', '192.168.1.2', 'offline'),
        ];

        $this->assertEquals(2, $result['recordsTotal']);
        $this->assertEquals(1, $result['recordsFiltered']);
        $this->assertEqualsCanonicalizing($expectedComputerTableData, $result['data']);
    }

    /**
     * @param array<int, array<string, mixed>> $computersData
     * @param string|null $searchTerm
     *
     * @return \PyzTest\Zed\Printer\Communication\Table\ComputerTableMock
     */
    protected function createComputerTableMock(array $computersData, ?string $searchTerm = null): ComputerTableMock
    {
        $computerTransfers = [];

        foreach ($computersData as $data) {
            $computerTransfers[] = (new ComputerTransfer())
                ->fromArray($data, true);
        }

        $printerClientMock = $this->getMockBuilder(PrinterClientInterface::class)
            ->getMock();
        $printerClientMock->method('getComputers')
            ->willReturn($computerTransfers);

        return new ComputerTableMock(
            $printerClientMock,
            $searchTerm,
        );
    }

    /**
     * @param int $idComputer
     * @param string $computerName
     * @param string $hostname
     * @param string $inet
     * @param string $state
     *
     * @return array
     */
    protected function buildExpectedRow(int $idComputer, string $computerName, string $hostname, string $inet, string $state): array
    {
        return [
            ComputerTableMock::COL_ID => $idComputer,
            ComputerTableMock::COL_NAME => $computerName,
            ComputerTableMock::COL_HOSTNAME => $hostname,
            ComputerTableMock::COL_INET => $inet,
            ComputerTableMock::COL_STATE => $state,
        ];
    }
}
