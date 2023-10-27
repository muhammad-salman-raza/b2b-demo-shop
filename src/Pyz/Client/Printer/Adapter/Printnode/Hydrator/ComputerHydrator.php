<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Adapter\Printnode\Hydrator;

use Generated\Shared\Transfer\ComputerTransfer;

class ComputerHydrator
{
    /**
     * @param array<string, mixed> $data
     *
     * @return \Generated\Shared\Transfer\ComputerTransfer
     */
    public function hydrate(array $data): ComputerTransfer
    {
        $computerTransfer = (new ComputerTransfer())
            ->fromArray($data, true);

        if (isset($data['id'])) {
            $computerTransfer->setComputerId($data['id']);
        }

        return $computerTransfer;
    }
}
