<?php
namespace Tests;

use Magium\Magento\AbstractMagentoTestCase;
use Magium\Magento\Navigators\BaseMenu;
use Magium\Magento\Navigators\Catalog\Product;

class GoodTest extends AbstractMagentoTestCase
{
    /**
     * Tests user story https://10nsoftware.tpondemand.com/entity/195
     */

    public function testFindSomethingNiceForMyWife()
    {
        $this->commandOpen($this->getTheme()->getBaseUrl());
        $this->getNavigator(BaseMenu::NAVIGATOR)->navigateTo('Accessories/Jewelry');
        $this->getNavigator(Product::NAVIGATOR)->navigateTo('Blue Horizons Bracelets');
        $this->assertTitleContains('Blue Horizons Bracelets');
    }
}