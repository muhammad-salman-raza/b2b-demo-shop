<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer;

use GuzzleHttp\Client;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\ComputerHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrinterHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrintJobHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\ProfileHydrator;
use Pyz\Client\Printer\Adapter\Printnode\PrintNodePrintAdapter;
use Pyz\Client\Printer\Adapter\Printnode\PrintNodeReaderAdapter;
use Pyz\Client\Printer\Model\Print\PrintAdapterInterface;
use Pyz\Client\Printer\Model\Print\Printer;
use Pyz\Client\Printer\Model\Print\PrintInterface;
use Pyz\Client\Printer\Model\Reader\Reader;
use Pyz\Client\Printer\Model\Reader\ReaderAdapterInterface;
use Pyz\Client\Printer\Model\Reader\ReaderInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * @method \Pyz\Client\Printer\PrinterConfig getConfig()
 */
class PrinterFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Client\Printer\Model\Reader\ReaderInterface
     */
    public function getReader(): ReaderInterface
    {
        return new Reader($this->createPrintNodeReaderAdapter());
    }

    /**
     * @return \Pyz\Client\Printer\Model\Print\PrintInterface
     */
    public function createPrinter(): PrintInterface
    {
        return new Printer(
            $this->getReader(),
            $this->createPrintNodePrintAdapter(),
        );
    }

    /**
     * @return \Pyz\Client\Printer\Model\Reader\ReaderAdapterInterface
     */
    protected function createPrintNodeReaderAdapter(): ReaderAdapterInterface
    {
        return new PrintNodeReaderAdapter(
            $this->createPrintNodeHttpClient(),
            $this->getConfig()->getPrintNodeAPIKey(),
            $this->createProfileHydrator(),
            $this->createComputerHydrator(),
            $this->createPrinterHydrator(),
            $this->createPrintJobHydrator(),
        );
    }

    /**
     * @return \Pyz\Client\Printer\Model\Print\PrintAdapterInterface
     */
    protected function createPrintNodePrintAdapter(): PrintAdapterInterface
    {
        return new PrintNodePrintAdapter(
            $this->createPrintNodeHttpClient(),
            $this->getConfig()->getPrintNodeAPIKey(),
        );
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\ComputerHydrator
     */
    public function createComputerHydrator(): ComputerHydrator
    {
        return new ComputerHydrator();
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\ProfileHydrator
     */
    public function createProfileHydrator(): ProfileHydrator
    {
        return new ProfileHydrator();
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrinterHydrator
     */
    public function createPrinterHydrator(): PrinterHydrator
    {
        return new PrinterHydrator(
            $this->createComputerHydrator(),
        );
    }

    /**
     * @return \Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrintJobHydrator
     */
    public function createPrintJobHydrator(): PrintJobHydrator
    {
        return new PrintJobHydrator(
            $this->createPrinterHydrator(),
        );
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function createPrintNodeHttpClient(): Client
    {
        return new Client([
            'base_uri' => $this->getConfig()->getPrintNodeBaseUrl(),
        ]);
    }
}
