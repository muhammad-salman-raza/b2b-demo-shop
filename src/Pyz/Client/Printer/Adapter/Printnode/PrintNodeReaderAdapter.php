<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Adapter\Printnode;

use Generated\Shared\Transfer\PrinterProfileTransfer;
use Generated\Shared\Transfer\PrinterTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\ComputerHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrinterHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrintJobHydrator;
use Pyz\Client\Printer\Adapter\Printnode\Hydrator\ProfileHydrator;
use Pyz\Client\Printer\Exception\PrinterNotFoundException;
use Pyz\Client\Printer\Model\Reader\ReaderAdapterInterface;

class PrintNodeReaderAdapter implements ReaderAdapterInterface
{
    /**
     * @var string
     */
    private const URI_WHOAMI = 'whoami';

    /**
     * @var string
     */
    private const URI_COMPUTERS = 'computers';

    /**
     * @var string
     */
    private const URI_PRINTERS = 'printers';

    /**
     * @var string
     */
    private const URI_PRINT_JOBS = 'printjobs';

    /**
     * @param \GuzzleHttp\Client $client
     * @param string $apiKey
     * @param \Pyz\Client\Printer\Adapter\Printnode\Hydrator\ProfileHydrator $profileHydrator
     * @param \Pyz\Client\Printer\Adapter\Printnode\Hydrator\ComputerHydrator $computerHydrator
     * @param \Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrinterHydrator $printerHydrator
     * @param \Pyz\Client\Printer\Adapter\Printnode\Hydrator\PrintJobHydrator $printJobHydrator
     */
    public function __construct(
        private Client $client,
        private string $apiKey,
        private ProfileHydrator $profileHydrator,
        private ComputerHydrator $computerHydrator,
        private PrinterHydrator $printerHydrator,
        private PrintJobHydrator $printJobHydrator
    ) {
    }

    /**
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function getProfile(): PrinterProfileTransfer
    {
        return $this->profileHydrator->hydrate(
            $this->doRequest(self::URI_WHOAMI),
        );
    }

    /**
     * @return array<\Generated\Shared\Transfer\ComputerTransfer>
     */
    public function getComputers(): array
    {
        return array_map(
            fn ($computer) => $this->computerHydrator->hydrate($computer),
            $this->doRequest(self::URI_COMPUTERS),
        );
    }

    /**
     * @return array<\Generated\Shared\Transfer\PrinterTransfer>
     */
    public function getPrinters(): array
    {
        return array_map(
            fn ($printer) => $this->printerHydrator->hydrate($printer),
            $this->doRequest(self::URI_PRINTERS),
        );
    }

    /**
     * @return array<\Generated\Shared\Transfer\PrintJobTransfer>
     */
    public function getPrintJobs(): array
    {
        return array_map(
            fn ($printJob) => $this->printJobHydrator->hydrate($printJob),
            $this->doRequest(self::URI_PRINT_JOBS),
        );
    }

    /**
     * @param int $printerId
     *
     * @return \Generated\Shared\Transfer\PrinterTransfer|null
     */
    public function getSinglePrinter(int $printerId): ?PrinterTransfer
    {
        $response = $this->doRequest(self::URI_PRINTERS . '/' . $printerId);

        return isset($response[0])
            ? $this->printerHydrator->hydrate($response[0])
            : null;
    }

    /**
     * @param string $uri
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterNotFoundException
     *
     * @return array<mixed>
     */
    private function doRequest(string $uri): array
    {
        try {
            $response = $this->client->get($uri, [
                'auth' => [$this->apiKey, ''],
            ]);
        } catch (GuzzleException $exception) {
            throw new PrinterNotFoundException('Can\'t connect to printer');
        }

        return json_decode(
            $response->getBody()->getContents(),
            true,
        );
    }
}
