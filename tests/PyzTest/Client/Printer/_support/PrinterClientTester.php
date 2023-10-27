<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PyzTest\Client\Printer;

use Codeception\Actor;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\ComputerHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrinterHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrintJobHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\ProfileHydrator;
use Pyz\Client\Printer\Adapter\Printnode\PrintNodeReaderAdapter;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(\PyzTest\Client\Printer\PHPMD)
 */
class PrinterClientTester extends Actor
{
    use _generated\PrinterClientTesterActions;

    /**
     * @param \GuzzleHttp\Handler\MockHandler $mockHandler
     *
     * @return \Pyz\Client\Printer\Adapter\Printnode\PrintNodeReaderAdapter
     */
    public function createPrintNodeReaderAdapter(MockHandler $mockHandler): PrintNodeReaderAdapter
    {
        // Create a handler stack and use the mock handler.
        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        return new PrintNodeReaderAdapter(
            $client,
            'test key',
            $this->createProfileHydrator(),
            $this->createComputerHydrator(),
            $this->createPrinterHydrator(),
            $this->createPrintJobHydrator(),
        );
    }

    /**
     * @param \PHPUnit\Framework\MockObject\MockObject|\GuzzleHttp\Client $client
     *
     * @return \Pyz\Client\Printer\Adapter\Printnode\PrintNodeReaderAdapter
     */
    public function createPrintNodeReaderAdapterWithException(Client $client): PrintNodeReaderAdapter
    {
        return new PrintNodeReaderAdapter(
            $client,
            'test key',
            $this->createProfileHydrator(),
            $this->createComputerHydrator(),
            $this->createPrinterHydrator(),
            $this->createPrintJobHydrator(),
        );
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\ProfileHydrator
     */
    private function createProfileHydrator(): ProfileHydrator
    {
        return new ProfileHydrator();
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\ComputerHydrator
     */
    private function createComputerHydrator(): ComputerHydrator
    {
        return new ComputerHydrator();
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrinterHydrator
     */
    private function createPrinterHydrator(): PrinterHydrator
    {
        return new PrinterHydrator(
            $this->createComputerHydrator(),
        );
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrintJobHydrator
     */
    private function createPrintJobHydrator(): PrintJobHydrator
    {
        return new PrintJobHydrator(
            $this->createPrinterHydrator(),
        );
    }
}
