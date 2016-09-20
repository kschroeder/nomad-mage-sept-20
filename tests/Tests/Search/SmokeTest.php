<?php

namespace Nomad\Tests\Search;

use Magium\Magento\Actions\Search\Search;
use Magium\Magento\Extractors\Catalog\ProductCollection;
use Magium\Magento\Extractors\Catalog\Products\ProductGrid;
use Magium\WebDriver\WebDriver;
use Nomad\Tests\AbstractTestCase;

class SmokeTest extends AbstractTestCase
{

    public function testSearchResults()
    {
        $this->commandOpen($this->getTheme()->getBaseUrl());
        $this->getAction(Search::ACTION)->search($this->getTheme()->getDefaultSimpleProductName());

        if (getenv('RUN_EXTRACTOR')) {
            // If your theme is configured for the extractor (there are a LOT of xpaths for this)
            $extractor = $this->getExtractor(ProductGrid::EXTRACTOR);
            /* @var $extractor ProductGrid */
            $result = $extractor->getProductList();
            self::assertNotCount(0, $$result);
        } else {
            $this->assertElementExists($this->getTheme()->getProductPageForCategory(), WebDriver::BY_XPATH);
        }
    }

}