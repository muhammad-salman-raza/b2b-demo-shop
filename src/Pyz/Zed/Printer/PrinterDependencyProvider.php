<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer;

use Pyz\Client\Printer\PrinterClientInterface;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Pyz\Zed\Printer\PrinterConfig getConfig()
 */
class PrinterDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRINTER = 'CLIENT_PRINTER';

    /**
     * @var string
     */
    public const SERVICE_UTIL_DATETIME = 'SERVICE_UTIL_DATETIME';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addPrinterClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addPrinterClient($container);
        $container = $this->addUtilDateTimeService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPrinterClient(Container $container): Container
    {
        $container->set(
            static::CLIENT_PRINTER,
            fn (Container $container): PrinterClientInterface => $container->getLocator()->printer()->client()
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilDateTimeService(Container $container): Container
    {
        $container->set(
            static::SERVICE_UTIL_DATETIME,
            fn (Container $container): UtilDateTimeServiceInterface => $container->getLocator()->utilDateTime()->service()
        );

        return $container;
    }
}
