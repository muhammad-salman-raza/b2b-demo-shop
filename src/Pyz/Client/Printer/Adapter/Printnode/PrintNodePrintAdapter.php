<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Adapter\Printnode;

use Generated\Shared\Transfer\PrintRequestTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Pyz\Client\Printer\Exception\PrinterNotFoundException;
use Pyz\Client\Printer\Model\Print\PrintAdapterInterface;
use Symfony\Component\HttpFoundation\Response;

class PrintNodePrintAdapter implements PrintAdapterInterface
{
    /**
     * @var string
     */
    private const URI_PRINT = 'printjobs';

    /**
     * @param \GuzzleHttp\Client $client
     * @param string $apiKey
     */
    public function __construct(
        private Client $client,
        private string $apiKey
    ) {
    }

    /**
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @return bool
     */
    public function print(PrintRequestTransfer $printRequestTransfer): bool
    {
        $data = $printRequestTransfer->toArray(false, true);

        if ($printRequestTransfer->getOptions() !== null) {
            $options = $printRequestTransfer->getOptions()->toArray();
            $data['options'] = array_filter($options, fn ($value) => $value !== null);
        }

        if ($printRequestTransfer->getAuthentication() !== null) {
            $data['authentication'] = [
                'type' => $printRequestTransfer->getAuthentication()->getType(),
                'credentials' => [
                    'user' => $printRequestTransfer->getAuthentication()->getUser(),
                    'pass' => $printRequestTransfer->getAuthentication()->getPass(),
                ],
            ];
        }
        $data['printerId'] = $printRequestTransfer->getPrinter()?->getPrinterId();

        unset($data['printer']);
        $data = array_filter($data, fn ($value) => $value !== null);

        return $this->doRequest(self::URI_PRINT, $data);
    }

    /**
     * @param string $uri
     * @param array<string, mixed> $data
     *
     * @throws \Pyz\Client\Printer\Exception\PrinterNotFoundException
     *
     * @return bool
     */
    private function doRequest(string $uri, array $data): bool
    {
        try {
            $response = $this->client->post('printjobs', [
                'auth' => [$this->apiKey, ''],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            return $response->getStatusCode() === Response::HTTP_CREATED;
        } catch (GuzzleException $exception) {
            throw new PrinterNotFoundException('Can\'t connect to printer');
        }
    }
}
