<?php

namespace Nomad\Tests\Navigation;

use Magium\Magento\Navigators\Catalog\DefaultSimpleProduct;
use Magium\Magento\Navigators\Catalog\DefaultSimpleProductCategory;
use Nomad\Tests\AbstractTestCase;

class SmokeTest extends AbstractTestCase 
{

    public function testNavigateToDefaultProduct()
    {
        $this->commandOpen($this->getTheme()->getBaseUrl());
        $this->getNavigator(DefaultSimpleProductCategory::NAVIGATOR)->navigateTo();
        $this->getNavigator(DefaultSimpleProduct::NAVIGATOR)->navigateTo();

        $this->assertTitleContains($this->getTheme()->getDefaultSimpleProductName());
    }

}