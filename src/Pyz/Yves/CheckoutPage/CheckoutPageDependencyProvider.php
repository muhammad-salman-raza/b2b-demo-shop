<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CheckoutPage;

use Spryker\Yves\Kernel\Container;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use SprykerShop\Yves\CheckoutPage\CheckoutPageDependencyProvider as SprykerShopCheckoutPageDependencyProvider;
use SprykerShop\Yves\CustomerPage\Form\CheckoutAddressCollectionForm;
use SprykerShop\Yves\CustomerPage\Form\CustomerCheckoutForm;
use SprykerShop\Yves\CustomerPage\Form\DataProvider\CheckoutAddressFormDataProvider;
use SprykerShop\Yves\CustomerPage\Form\GuestForm;
use SprykerShop\Yves\CustomerPage\Form\LoginForm;
use SprykerShop\Yves\CustomerPage\Form\RegisterForm;
use SprykerShop\Yves\DiscountWidget\Plugin\CheckoutPage\CheckoutVoucherFormWidgetPlugin;
use Symfony\Component\Form\FormTypeInterface;

class CheckoutPageDependencyProvider extends SprykerShopCheckoutPageDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getSummaryPageWidgetPlugins(): array
    {
        return [
            CheckoutVoucherFormWidgetPlugin::class,
        ];
    }

    /**
     * @return FormTypeInterface[]
     */
    protected function getCustomerStepSubForms()
    {
        return [
            new LoginForm(),
            new CustomerCheckoutForm(new RegisterForm()),
            new CustomerCheckoutForm(new GuestForm()),
        ];
    }

    /**
     * @return FormTypeInterface[]
     */
    protected function getAddressStepSubForms()
    {
        return [
            new CheckoutAddressCollectionForm(),
        ];
    }

    /**
     * @param Container $container
     *
     * @return StepEngineFormDataProviderInterface|null
     */
    protected function getAddressStepFormDataProvider(Container $container)
    {
        return new CheckoutAddressFormDataProvider($this->getCustomerClient($container), $this->getStore());
    }
}