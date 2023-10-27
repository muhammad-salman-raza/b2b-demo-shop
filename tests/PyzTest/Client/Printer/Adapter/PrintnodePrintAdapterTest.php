<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Client\Printer\Adapter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PrinterTransfer;
use Generated\Shared\Transfer\PrintRequestTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;
use Pyz\Client\Printer\Adapter\Printnode\PrintNodePrintAdapter;
use Pyz\Client\Printer\Exception\PrinterNotFoundException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Client
 * @group Printer
 * @group Adapter
 * @group PrintnodePrintAdapterTest
 * Add your own group annotations below this line
 */
class PrintnodePrintAdapterTest extends Unit
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
    public function testPrintSuccess()
    {
        // Mock the response to return a successful status code
        $responseMock = new Response(HttpResponse::HTTP_CREATED);

        $printerTransfer = (new PrinterTransfer())
            ->setPrinterId(456);

        $printRequestTransfer = (new PrintRequestTransfer())
            ->setContentType('pdf_uri')
            ->setSource('spryker')
            ->setContent('test content')
            ->setTitle('test title')
            ->setQty(3)
            ->setPrinter($printerTransfer);

        $expectedData = [
            'contentType' => 'pdf_uri',
            'content' => 'test content',
            'title' => 'test title',
            'source' => 'spryker',
            'qty' => 3,
            'printerId' => 456,
        ];

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('printjobs'), // URL endpoint
                $this->callback(function ($params) use ($expectedData) {
                    $this->assertEquals($this->apiKey, $params['auth'][0]);
                    $this->assertEquals('', $params['auth'][1]);
                    $this->assertEquals($expectedData, $params['json']);

                    return true;
                }),
            )
            ->willReturn(new Response(HttpResponse::HTTP_CREATED));

        $this->clientMock->method('post')
            ->willReturn($responseMock);

        $result = $this->printAdapter->print($printRequestTransfer);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testPrintThrowsPrinterNotFoundExceptionOnGuzzleException()
    {
        $this->clientMock->method('post')
            ->will($this->throwException(new TransferException('Error communicating with server')));

        $this->expectException(PrinterNotFoundException::class);
        $this->expectExceptionMessage("Can't connect to printer");

        $this->printAdapter->print(new PrintRequestTransfer());
    }
}
