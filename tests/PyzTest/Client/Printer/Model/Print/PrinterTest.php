<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Client\Printer\Model\Print;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PrinterTransfer;
use Generated\Shared\Transfer\PrintRequestTransfer;
use GuzzleHttp\Client;
use Pyz\Client\Printer\Adapter\Printnode\PrintNodePrintAdapter;
use Pyz\Client\Printer\Exception\PrinterNotFoundException;
use Pyz\Client\Printer\Model\Print\PrintAdapterInterface;
use Pyz\Client\Printer\Model\Print\Printer;
use Pyz\Client\Printer\Model\Reader\ReaderInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Client
 * @group Printer
 * @group Model
 * @group Print
 * @group PrinterTest
 * Add your own group annotations below this line
 */
class PrinterTest extends Unit
{
    /**
     * @var \PyzTest\Client\Printer\PrinterClientTester
     */
    protected $tester;

    private Client $clientMock;

    private string $apiKey = 'testApiKey';

    /**
     * @return void
     */
    protected function setUp(): void
    {
        // Create a mock of the Guzzle client
        $this->clientMock = $this->createMock(Client::class);

        // Instantiate the PrintNodePrintAdapter with the mock client
        $this->printAdapter = new PrintNodePrintAdapter($this->clientMock, $this->apiKey);
    }

    /**
     * @return void
     */
    public function testPrintSuccessfullyForwardsPrintRequest()
    {
        $readerMock = $this->createMock(ReaderInterface::class);
        $adapterMock = $this->createMock(PrintAdapterInterface::class);

        $printerTransfer = (new PrinterTransfer())
            ->setPrinterId(123);

        $printRequestTransfer = (new PrintRequestTransfer())
            ->setPrinter($printerTransfer);

        // Expect the adapter to receive the print request and return true
        $adapterMock->expects($this->once())
            ->method('print')
            ->with($printRequestTransfer)
            ->willReturn(true);

        $readerMock->expects($this->once())
            ->method('getSinglePrinter')
            ->with(123)
            ->willReturn($printerTransfer);

        $readerMock->expects($this->never())
            ->method('getDefaultPrinter');

        $printer = new Printer($readerMock, $adapterMock);
        $result = $printer->print($printRequestTransfer);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testPrintSetsDefaultPrinterAndForwardsPrintRequest()
    {
        $readerMock = $this->createMock(ReaderInterface::class);
        $adapterMock = $this->createMock(PrintAdapterInterface::class);

        $printerTransfer = (new PrinterTransfer())
            ->setPrinterId(123);

        $printRequestTransfer = (new PrintRequestTransfer());

        // Expect the adapter to receive the print request and return true
        $adapterMock->expects($this->once())
            ->method('print')
            ->with($printRequestTransfer)
            ->willReturn(true);

        $readerMock->expects($this->never())
            ->method('getSinglePrinter');

        $readerMock->expects($this->once())
            ->method('getDefaultPrinter')
            ->willReturn($printerTransfer);

        $printer = new Printer($readerMock, $adapterMock);
        $result = $printer->print($printRequestTransfer);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testPrintThrowsPrinterNotFoundException()
    {
        $readerMock = $this->createMock(ReaderInterface::class);
        $adapterMock = $this->createMock(PrintAdapterInterface::class);

        $printerTransfer = (new PrinterTransfer())
            ->setPrinterId(123);

        $printRequestTransfer = (new PrintRequestTransfer())
            ->setPrinter($printerTransfer);

        // Expect the adapter to receive the print request and return true
        $adapterMock->expects($this->never())
            ->method('print');

        $readerMock->expects($this->never())
            ->method('getDefaultPrinter');

        $readerMock->expects($this->once())
            ->method('getSinglePrinter')
            ->willReturn(null);

        $this->expectException(PrinterNotFoundException::class);
        $this->expectExceptionMessage('Requested printer is not avaialble.');

        $printer = new Printer($readerMock, $adapterMock);
        $result = $printer->print($printRequestTransfer);
    }
}
