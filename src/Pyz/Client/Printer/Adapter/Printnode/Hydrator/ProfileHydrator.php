<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Client\Printer\Adapter\Printnode\Hydrator;

use Generated\Shared\Transfer\PrinterProfileTransfer;

class ProfileHydrator
{
    /**
     * @param array<string, mixed> $data
     *
     * @return \Generated\Shared\Transfer\PrinterProfileTransfer
     */
    public function hydrate(array $data): PrinterProfileTransfer
    {
        $profileTransfer = (new PrinterProfileTransfer())
            ->fromArray($data, true);

        if (isset($data['id'])) {
            $profileTransfer->setProfileId($data['id']);
        }

        if (isset($data['firstname'])) {
            $profileTransfer->setFirstName($data['firstname']);
        }

        if (isset($data['lastname'])) {
            $profileTransfer->setLastName($data['lastname']);
        }

        return $profileTransfer;
    }
}
