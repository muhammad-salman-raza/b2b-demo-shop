<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Communication\Controller;

use Pyz\Client\Printer\Exception\PrinterException;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Printer\Communication\PrinterCommunicationFactory getFactory()
 * @method \Pyz\Zed\Printer\Business\PrinterFacadeInterface getFacade()()
 */
class IndexController extends AbstractController
{
    /**
     * @return array<string, mixed>
     */
    public function indexAction(): array
    {
        try {
            return $this->viewResponse([
                'printerProfile' => $this->getFacade()->getProfile(),
                'printerTable' => $this->getFactory()->createPrinterDataTable()->render(),
                'computerTable' => $this->getFactory()->createComputerDataTable()->render(),
                'printJobTable' => $this->getFactory()->createPrintJobTableDataTable()->render(),
            ]);
        } catch (PrinterException $exception) {
            $this->addErrorMessage($exception->getMessage());

            return $this->viewResponse([
                'printerProfile' => null,
                'printerTable' => null,
                'computerTable' => null,
                'printJobTable' => null,
            ]);
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|array<string, mixed>
     */
    public function printAction(Request $request)
    {
        try {
            $printForm = $this->getFactory()->createPrintForm();
        } catch (PrinterException $exception) {
            $this->addErrorMessage($exception->getMessage());

            return $this->redirectResponse('/printer/index');
        }

        $printForm->handleRequest($request);

        if ($printForm->isSubmitted() && $printForm->isValid()) {
            /** @var \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer */
            $printRequestTransfer = $printForm->getData();

            try {
                if ($this->getFacade()->print($printRequestTransfer)) {
                    $this->addSuccessMessage('Printed successfully');

                    return $this->redirectResponse('/printer/index');
                }

                $this->addErrorMessage('An error occurred. Please try again.');
            } catch (PrinterException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->viewResponse([
            'printForm' => $printForm->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function printerTableAction(): JsonResponse
    {
        $printerTable = $this->getFactory()->createPrinterDataTable();

        return $this->jsonResponse(
            $printerTable->fetchData(),
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function printjobTableAction(): JsonResponse
    {
        $printerTable = $this->getFactory()->createPrintJobTableDataTable();

        return $this->jsonResponse(
            $printerTable->fetchData(),
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function computerTableAction(): JsonResponse
    {
        $printerTable = $this->getFactory()->createComputerDataTable();

        return $this->jsonResponse(
            $printerTable->fetchData(),
        );
    }
}
