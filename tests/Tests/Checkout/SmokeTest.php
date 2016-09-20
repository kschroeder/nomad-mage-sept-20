<?php
namespace Nomad\Tests\Checkout;

use Magium\Magento\Actions\Cart\AddSimpleProductToCart;
use Magium\Magento\Actions\Checkout\CustomerCheckout;
use Magium\Magento\Actions\Checkout\GuestCheckout;
use Magium\Magento\Actions\Checkout\RegisterNewCustomerCheckout;
use Magium\Magento\Extractors\Checkout\OrderId;
use Magium\Magento\Navigators\Catalog\DefaultSimpleProduct;
use Magium\Magento\Navigators\Catalog\DefaultSimpleProductCategory;
use Nomad\Tests\AbstractTestCase;

class SmokeTest extends AbstractTestCase
{

    public function testGuestCheckoutWorks()
    {
        $this->setPaymentMethod('CashOnDelivery');
        $this->commandOpen($this->getTheme()->getBaseUrl());
        $this->getNavigator(DefaultSimpleProductCategory::NAVIGATOR)->navigateTo();
        $this->getNavigator(DefaultSimpleProduct::NAVIGATOR)->navigateTo();
        $this->getAction(AddSimpleProductToCart::ACTION)->execute();
        $this->getAction(GuestCheckout::ACTION)->execute();

        $orderId = $this->getExtractor(OrderId::EXTRACTOR)->getOrderId();
        self::assertNotNull($orderId);
    }

    public function testRegisteredCustomerCheckoutWorks()
    {
        $this->setPaymentMethod('CashOnDelivery');
        $this->commandOpen($this->getTheme()->getBaseUrl());
        $this->getNavigator(DefaultSimpleProductCategory::NAVIGATOR)->navigateTo();
        $this->getNavigator(DefaultSimpleProduct::NAVIGATOR)->navigateTo();
        $this->getAction(AddSimpleProductToCart::ACTION)->execute();
        // The next step may require changes to the customer Identity
        $this->getAction(CustomerCheckout::ACTION)->execute();

        $orderId = $this->getExtractor(OrderId::EXTRACTOR)->getOrderId();
        self::assertNotNull($orderId);
    }

    public function testNewCustomerCheckoutWorks()
    {
        $this->setPaymentMethod('CashOnDelivery');
        $this->commandOpen($this->getTheme()->getBaseUrl());
        $this->getNavigator(DefaultSimpleProductCategory::NAVIGATOR)->navigateTo();
        $this->getNavigator(DefaultSimpleProduct::NAVIGATOR)->navigateTo();
        $this->getAction(AddSimpleProductToCart::ACTION)->execute();
        // The next step may require changes to the customer Identity
        $this->getAction(RegisterNewCustomerCheckout::ACTION)->execute();

        $orderId = $this->getExtractor(OrderId::EXTRACTOR)->getOrderId();
        self::assertNotNull($orderId);
    }

}