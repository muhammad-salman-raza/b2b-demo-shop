<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Client\Printer\Adapter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ComputerTransfer;
use Generated\Shared\Transfer\PrinterProfileTransfer;
use Generated\Shared\Transfer\PrinterTransfer;
use Generated\Shared\Transfer\PrintJobTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Pyz\Client\Printer\Exception\PrinterNotFoundException;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Client
 * @group Printer
 * @group Adapter
 * @group PrintnodeReaderAdapterTest
 * Add your own group annotations below this line
 */
class PrintnodeReaderAdapterTest extends Unit
{
 /**
  * @var \PyzTest\Client\Printer\PrinterClientTester
  */
    protected $tester;

    /**
     * @return void
     */
    public function testGetProfile()
    {
        // Create a mock handler and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], '{"ApiKeys":[],"Tags":[],"canCreateSubAccounts":false,"childAccounts":[],"connected":[],"creatorEmail":null,"creatorRef":null,"credits":null,"email":"test@printnode.com","firstname":"Print","id":335732,"lastname":"node","numComputers":1,"permissions":["Unrestricted"],"state":"active","totalPrints":20,"versions":[]}'),
        ]);

        $printerClient = $this->tester->createPrintNodeReaderAdapter($mock);

        // Perform the operation that triggers the API call.
        $result = $printerClient->getProfile();

        // Assert that the response is what you expect.
        $expectedResult = (new PrinterProfileTransfer())
            ->setProfileId(335732)
            ->setFirstName('Print')
            ->setLastName('node')
            ->setEmail('test@printnode.com')
            ->setState('active')
            ->setNumComputers(1)
            ->setTotalPrints(20);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return void
     */
    public function testGetComputers()
    {
        // Create a mock handler and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], '[{"createTimestamp":"2023-10-23T17:50:51.509Z","hostname":"test@PRINTNODE.LOCAL","id":528670,"inet":"192.168.1.1","inet6":null,"jre":null,"name":"TEST_PRINTNODE","state":"disconnected","version":"4.27.11"}]'),
        ]);

        $printerClient = $this->tester->createPrintNodeReaderAdapter($mock);

        // Perform the operation that triggers the API call.
        $result = $printerClient->getComputers();

        // Assert that the response is what you expect.
        $expectedResult = (new ComputerTransfer())
            ->setComputerId(528670)
            ->setName('TEST_PRINTNODE')
            ->setHostname('test@PRINTNODE.LOCAL')
            ->setInet('192.168.1.1')
            ->setState('disconnected');

        $this->assertCount(1, $result);
        $this->assertEquals($expectedResult, $result[0]);
    }

    /**
     * @return void
     */
    public function testGetPrinters()
    {
        $response = '[{"capabilities":{"bins":[],"collate":true,"color":true,"copies":9999,"dpis":[],"duplex":true,"extent":null,"medias":["any","stationery","photographic-glossy"],"nup":[1,2,4,6,9,16],"papers":{"100x150mm":[null,null],"100x150mm.Fullbleed":[null,null],"3.5x5":[null,null],"3.5x5.Fullbleed":[null,null],"3x5":[null,null],"4x6":[null,null],"4x6.Fullbleed":[null,null],"5x7":[1270,1778],"5x7.Fullbleed":[null,null],"5x8":[null,null],"8x10":[null,null],"8x10.Fullbleed":[null,null],"A4":[2100,2970],"A4.Fullbleed":[null,null],"A5":[1480,2100],"A5.Fullbleed":[null,null],"A6":[1050,1480],"A6.Fullbleed":[null,null],"B5":[1760,2500],"B5.Fullbleed":[null,null],"Env10":[3240,4580],"EnvA2":[4200,5940],"EnvC5":[1620,2290],"EnvC6":[1140,1620],"EnvChou3":[1200,2350],"EnvChou4":[900,2050],"EnvDL":[1100,2200],"EnvMonarch":[984,1905],"EnvPersonal":[921,1651],"Executive":[1842,2667],"FanFoldGermanLegal":[null,null],"ISOB5":[1760,2500],"Legal":[2159,3556],"Letter":[2159,2794],"Letter.Fullbleed":[null,null],"Postcard":[null,null],"Postcard.Fullbleed":[null,null],"Statement":[null,null]},"printrate":null,"supports_custom_paper_size":true},"computer":{"createTimestamp":"2023-10-23T17:50:51.509Z","hostname":"test@PRINTNODE.LOCAL","id":528670,"inet":"192.168.1.1","inet6":null,"jre":null,"name":"TEST_PRINTNODE","state":"disconnected","version":"4.27.11"},"createTimestamp":"2023-10-23T17:50:51.558Z","default":true,"description":"HP OfficeJet 3830 series 2","id":72743977,"name":"HP_OfficeJet_3830_series_2","state":"online"},{"capabilities":{"bins":[],"collate":true,"color":true,"copies":9999,"dpis":[],"duplex":true,"extent":null,"medias":[],"nup":[1,2,4,6,9,16],"papers":{"A4":[2100,2970],"Legal":[2159,3556],"Legal.Fullbleed":[null,null],"Letter":[2159,2794],"Letter.Fullbleed":[null,null]},"printrate":null,"supports_custom_paper_size":false},"computer":{"createTimestamp":"2023-10-23T17:50:51.509Z","hostname":"test@PRINTNODE.LOCAL","id":528670,"inet":"192.168.1.1","inet6":null,"jre":null,"name":"TEST_PRINTNODE","state":"disconnected","version":"4.27.11"},"createTimestamp":"2023-10-23T17:50:51.558Z","default":false,"description":"HP OfficeJet 3830 series - Fax","id":72743978,"name":"HP_OfficeJet_3830_series___Fax","state":"online"}]';
        // Create a mock handler and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $response),
            ]);

        $printerClient = $this->tester->createPrintNodeReaderAdapter($mock);

        // Perform the operation that triggers the API call.
        $result = $printerClient->getPrinters();

        // Assert that the response is what you expect.
        $computerTransfer = (new ComputerTransfer())
            ->setComputerId(528670)
            ->setName('TEST_PRINTNODE')
            ->setHostname('test@PRINTNODE.LOCAL')
            ->setInet('192.168.1.1')
            ->setState('disconnected');

        $expectedResult = (new PrinterTransfer())
            ->setPrinterId(72743977)
            ->setName('HP_OfficeJet_3830_series_2')
            ->setDescription('HP OfficeJet 3830 series 2')
            ->setComputer($computerTransfer)
            ->setDefault(true)
            ->setState('online');

        $this->assertCount(2, $result);
        $this->assertEquals($expectedResult, $result[0]);
        $this->assertFalse($result[1]->getDefault());
    }

    /**
     * @return void
     */
    public function testGetPrintjobs()
    {
        $response = '
        [{"contentType":"raw_uri","createTimestamp":"2023-10-31T23:53:49.738Z","expireAt":"2023-11-14T23:53:49.738432Z","id":3981377586,"printer":{"capabilities":{"bins":[],"collate":true,"color":true,"copies":9999,"dpis":[],"duplex":true,"extent":null,"medias":["any","stationery","photographic-glossy"],"nup":[1,2,4,6,9,16],"papers":{"100x150mm":[null,null],"100x150mm.Fullbleed":[null,null],"3.5x5":[null,null],"3.5x5.Fullbleed":[null,null],"3x5":[null,null],"4x6":[null,null],"4x6.Fullbleed":[null,null],"5x7":[1270,1778],"5x7.Fullbleed":[null,null],"5x8":[null,null],"8x10":[null,null],"8x10.Fullbleed":[null,null],"A4":[2100,2970],"A4.Fullbleed":[null,null],"A5":[1480,2100],"A5.Fullbleed":[null,null],"A6":[1050,1480],"A6.Fullbleed":[null,null],"B5":[1760,2500],"B5.Fullbleed":[null,null],"Env10":[3240,4580],"EnvA2":[4200,5940],"EnvC5":[1620,2290],"EnvC6":[1140,1620],"EnvChou3":[1200,2350],"EnvChou4":[900,2050],"EnvDL":[1100,2200],"EnvMonarch":[984,1905],"EnvPersonal":[921,1651],"Executive":[1842,2667],"FanFoldGermanLegal":[null,null],"ISOB5":[1760,2500],"Legal":[2159,3556],"Letter":[2159,2794],"Letter.Fullbleed":[null,null],"Postcard":[null,null],"Postcard.Fullbleed":[null,null],"Statement":[null,null]},"printrate":null,"supports_custom_paper_size":true},"computer":{"createTimestamp":"2023-10-23T17:50:51.509Z","hostname":"test@PRINTNODE.LOCAL","id":528670,"inet":"192.168.1.1","inet6":null,"jre":null,"name":"TEST_PRINTNODE","state":"disconnected","version":"4.27.11"},"createTimestamp":"2023-10-23T17:50:51.558Z","default":true,"description":"HP OfficeJet 3830 series 2","id":72743977,"name":"HP_OfficeJet_3830_series_2","state":"online"},"source":"Zed","state":"new","title":"print"},{"contentType":"raw_uri","createTimestamp":"2023-10-31T23:51:33.286Z","expireAt":"2023-11-14T23:51:33.286922Z","id":3981372713,"printer":{"capabilities":{"bins":[],"collate":true,"color":true,"copies":9999,"dpis":[],"duplex":true,"extent":null,"medias":["any","stationery","photographic-glossy"],"nup":[1,2,4,6,9,16],"papers":{"100x150mm":[null,null],"100x150mm.Fullbleed":[null,null],"3.5x5":[null,null],"3.5x5.Fullbleed":[null,null],"3x5":[null,null],"4x6":[null,null],"4x6.Fullbleed":[null,null],"5x7":[1270,1778],"5x7.Fullbleed":[null,null],"5x8":[null,null],"8x10":[null,null],"8x10.Fullbleed":[null,null],"A4":[2100,2970],"A4.Fullbleed":[null,null],"A5":[1480,2100],"A5.Fullbleed":[null,null],"A6":[1050,1480],"A6.Fullbleed":[null,null],"B5":[1760,2500],"B5.Fullbleed":[null,null],"Env10":[3240,4580],"EnvA2":[4200,5940],"EnvC5":[1620,2290],"EnvC6":[1140,1620],"EnvChou3":[1200,2350],"EnvChou4":[900,2050],"EnvDL":[1100,2200],"EnvMonarch":[984,1905],"EnvPersonal":[921,1651],"Executive":[1842,2667],"FanFoldGermanLegal":[null,null],"ISOB5":[1760,2500],"Legal":[2159,3556],"Letter":[2159,2794],"Letter.Fullbleed":[null,null],"Postcard":[null,null],"Postcard.Fullbleed":[null,null],"Statement":[null,null]},"printrate":null,"supports_custom_paper_size":true},"computer":{"createTimestamp":"2023-10-23T17:50:51.509Z","hostname":"test@PRINTNODE.LOCAL","id":528670,"inet":"192.168.1.1","inet6":null,"jre":null,"name":"TEST_PRINTNODE","state":"disconnected","version":"4.27.11"},"createTimestamp":"2023-10-23T17:50:51.558Z","default":true,"description":"HP OfficeJet 3830 series 2","id":72743977,"name":"HP_OfficeJet_3830_series_2","state":"online"},"source":"Zed","state":"new","title":"print"}]
        ';
        // Create a mock handler and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $response),
        ]);

        $printerClient = $this->tester->createPrintNodeReaderAdapter($mock);

        // Perform the operation that triggers the API call.
        $result = $printerClient->getPrintJobs();

        // Assert that the response is what you expect.
        $computerTransfer = (new ComputerTransfer())
            ->setComputerId(528670)
            ->setName('TEST_PRINTNODE')
            ->setHostname('test@PRINTNODE.LOCAL')
            ->setInet('192.168.1.1')
            ->setState('disconnected');

        $printerTransfer = (new PrinterTransfer())
            ->setPrinterId(72743977)
            ->setName('HP_OfficeJet_3830_series_2')
            ->setDescription('HP OfficeJet 3830 series 2')
            ->setComputer($computerTransfer)
            ->setDefault(true)
            ->setState('online');

        $expectedResult = (new PrintJobTransfer())
            ->setPrintjobId(3981377586)
            ->setTitle('print')
            ->setSource('Zed')
            ->setContentType('raw_uri')
            ->setCreateTimestamp('2023-10-31T23:53:49.738Z')
            ->setExpireAt('2023-11-14T23:53:49.738432Z')
            ->setState('new')
            ->setPrinter($printerTransfer);

        $this->assertCount(2, $result);
        $this->assertEquals($expectedResult, $result[0]);
    }

    /**
     * @return void
     */
    public function testGetSinglePrinter()
    {
        $response = '[{"capabilities":{"bins":[],"collate":true,"color":true,"copies":9999,"dpis":[],"duplex":true,"extent":null,"medias":["any","stationery","photographic-glossy"],"nup":[1,2,4,6,9,16],"papers":{"100x150mm":[null,null],"100x150mm.Fullbleed":[null,null],"3.5x5":[null,null],"3.5x5.Fullbleed":[null,null],"3x5":[null,null],"4x6":[null,null],"4x6.Fullbleed":[null,null],"5x7":[1270,1778],"5x7.Fullbleed":[null,null],"5x8":[null,null],"8x10":[null,null],"8x10.Fullbleed":[null,null],"A4":[2100,2970],"A4.Fullbleed":[null,null],"A5":[1480,2100],"A5.Fullbleed":[null,null],"A6":[1050,1480],"A6.Fullbleed":[null,null],"B5":[1760,2500],"B5.Fullbleed":[null,null],"Env10":[3240,4580],"EnvA2":[4200,5940],"EnvC5":[1620,2290],"EnvC6":[1140,1620],"EnvChou3":[1200,2350],"EnvChou4":[900,2050],"EnvDL":[1100,2200],"EnvMonarch":[984,1905],"EnvPersonal":[921,1651],"Executive":[1842,2667],"FanFoldGermanLegal":[null,null],"ISOB5":[1760,2500],"Legal":[2159,3556],"Letter":[2159,2794],"Letter.Fullbleed":[null,null],"Postcard":[null,null],"Postcard.Fullbleed":[null,null],"Statement":[null,null]},"printrate":null,"supports_custom_paper_size":true},"computer":{"createTimestamp":"2023-10-23T17:50:51.509Z","hostname":"test@PRINTNODE.LOCAL","id":528670,"inet":"192.168.1.1","inet6":null,"jre":null,"name":"TEST_PRINTNODE","state":"disconnected","version":"4.27.11"},"createTimestamp":"2023-10-23T17:50:51.558Z","default":true,"description":"HP OfficeJet 3830 series 2","id":72743977,"name":"HP_OfficeJet_3830_series_2","state":"online"}]';
        // Create a mock handler and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $response),
        ]);

        $printerClient = $this->tester->createPrintNodeReaderAdapter($mock);

        // Perform the operation that triggers the API call.
        $result = $printerClient->getSinglePrinter(123);

        // Assert that the response is what you expect.
        $computerTransfer = (new ComputerTransfer())
            ->setComputerId(528670)
            ->setName('TEST_PRINTNODE')
            ->setHostname('test@PRINTNODE.LOCAL')
            ->setInet('192.168.1.1')
            ->setState('disconnected');

        $expectedResult = (new PrinterTransfer())
            ->setPrinterId(72743977)
            ->setName('HP_OfficeJet_3830_series_2')
            ->setDescription('HP OfficeJet 3830 series 2')
            ->setComputer($computerTransfer)
            ->setDefault(true)
            ->setState('online');

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return void
     */
    public function testGetSinglePrinterRetunsNullWhenPrinterNotFound()
    {
        $response = '[]';
        // Create a mock handler and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $response),
        ]);

        $printerClient = $this->tester->createPrintNodeReaderAdapter($mock);

        // Perform the operation that triggers the API call.
        $result = $printerClient->getSinglePrinter(1234);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testGetSinglePrinterThrowsPrinterNotFoundException()
    {
        $mockClient = $this->createMock(Client::class);

        // Configure the mock to throw a GuzzleException when get is called
        $mockClient->method('get')
            ->will($this->throwException(new TransferException('Error communicating with server')));

        $printerClient = $this->tester->createPrintNodeReaderAdapterWithException($mockClient);

        // Expect a PrinterNotFoundException to be thrown
        $this->expectException(PrinterNotFoundException::class);

        $printerClient->getSinglePrinter(1234);
    }
}
