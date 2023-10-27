<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Communication;

use Pyz\Client\Printer\PrinterClientInterface;
use Pyz\Zed\Printer\Communication\DataProvider\PrintDataProvider;
use Pyz\Zed\Printer\Communication\Form\PrintFormType;
use Pyz\Zed\Printer\Communication\Table\ComputerTable;
use Pyz\Zed\Printer\Communication\Table\PrinterTable;
use Pyz\Zed\Printer\Communication\Table\PrintJobTable;
use Pyz\Zed\Printer\PrinterDependencyProvider;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\Printer\PrinterConfig getConfig()
 * @method \Pyz\Zed\Printer\Business\PrinterFacadeInterface getFacade()
 */
class PrinterCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\Printer\Communication\Table\PrinterTable
     */
    public function createPrinterDataTable(): PrinterTable
    {
        return new PrinterTable(
            $this->getPrinterClient(),
        );
    }

    /**
     * @return \Pyz\Zed\Printer\Communication\Table\PrintJobTable
     */
    public function createPrintJobTableDataTable(): PrintJobTable
    {
        return new PrintJobTable(
            $this->getPrinterClient(),
            $this->getUtilDateTimeService(),
        );
    }

    /**
     * @return \Pyz\Zed\Printer\Communication\Table\ComputerTable
     */
    public function createComputerDataTable(): ComputerTable
    {
        return new ComputerTable(
            $this->getPrinterClient(),
        );
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createPrintForm(): FormInterface
    {
        $dataProvider = $this->createPrintDataProvider();

        $form = $this->getFormFactory()->create(
            PrintFormType::class,
            $dataProvider->getData(),
            $dataProvider->getOptions(),
        );

        return $form;
    }

    /**
     * @return \Pyz\Zed\Printer\Communication\DataProvider\PrintDataProvider
     */
    public function createPrintDataProvider(): PrintDataProvider
    {
        return new PrintDataProvider($this->getPrinterClient());
    }

    /**
     * @return \Pyz\Client\Printer\PrinterClientInterface
     */
    private function getPrinterClient(): PrinterClientInterface
    {
        return $this->getProvidedDependency(PrinterDependencyProvider::CLIENT_PRINTER);
    }

    /**
     * @return \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface
     */
    private function getUtilDateTimeService(): UtilDateTimeServiceInterface
    {
        return $this->getProvidedDependency(PrinterDependencyProvider::SERVICE_UTIL_DATETIME);
    }
}
