<?php

namespace Tests\Admin\Product;

use Facebook\WebDriver\WebDriverSelect;
use Magium\Magento\AbstractMagentoTestCase;
use Magium\Magento\Actions\Admin\Login\Login;
use Magium\Magento\Actions\Admin\Tables\ClearTableFilters;
use Magium\Magento\Actions\Admin\Tables\ClickButton;
use Magium\Magento\Actions\Admin\WaitForLoadingMask;
use Magium\Magento\Actions\Admin\WaitForPageLoaded;
use Magium\Magento\Actions\Admin\Widget\ClickActionButton;
use Magium\Magento\Extractors\Admin\Widget\Attribute;
use Magium\Magento\Navigators\Admin\AdminMenu;
use Magium\Magento\Navigators\Admin\Widget\Tab;
use Magium\WebDriver\WebDriver;
use Tests\Magium\Magento\Admin\GridWidgetTest;

class SmokeTest extends AbstractMagentoTestCase
{

    public function testProductSave()
    {
        $sku = uniqid();

        $this->getAction(Login::ACTION)->execute();
        $this->getNavigator(AdminMenu::NAVIGATOR)->navigateTo('Catalog/Manage Products');
        $this->getAction(ClickActionButton::ACTION)->click('Add Product');
        $this->byText('Continue')->click();

        $this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('General::Name')
            ->sendKeys('Test Product');

        $this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('General::Description')
            ->sendKeys('A general description');

        $this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('General::Short Description')
            ->sendKeys('A short description');

        $this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('General::SKU')
            ->sendKeys($sku);

        $this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('General::Weight')
            ->sendKeys('1');

        (new WebDriverSelect($this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('General::Status')))->selectByVisibleText('Disabled');

        $this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('Prices::Price')
            ->sendKeys('9.99');


        (new WebDriverSelect($this->getExtractor(Attribute::EXTRACTOR)
            ->getElementByLabel('Prices::Tax Class')))->getOptions()[1]->click();

        $element = $this->byXpath('//body');
        $this->getAction(ClickActionButton::ACTION)->click('Save');
        $this->getAction(WaitForPageLoaded::ACTION)->execute($element);

        $this->getAction(ClearTableFilters::ACTION)->clear();
        $this->byId('productGrid_product_filter_sku')->sendKeys($sku);
        $this->getAction(ClickButton::ACTION)->click('Search');
        $this->getAction(WaitForLoadingMask::ACTION)->wait();

        $this->byText($sku)->click();

        $element = $this->byXpath('//body');
        $this->getAction(ClickActionButton::ACTION)->click('Delete');
        $this->webdriver->switchTo()->alert()->accept();
        $this->getAction(WaitForPageLoaded::ACTION)->execute($element);

        $this->byId('productGrid_product_filter_sku')->clear();
        $this->assertElementNotExists(sprintf('//*[.="%s"]', $sku), WebDriver::BY_XPATH);
    }

}