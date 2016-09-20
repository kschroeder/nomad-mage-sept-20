<?php

namespace Nomad\Tests;


use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class BadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests user story https://10nsoftware.tpondemand.com/entity/195
     */

    public function testFindSomethingNiceForMyWife()
    {

        $webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::chrome());
        $webDriver->get('http://magento19.loc/');
        $element = $webDriver->findElement(
            WebDriverBy::xpath(
                '//nav[@id="nav"]/descendant::li[contains(concat(" ",normalize-space(@class)," ")," level0 ")]'
                . '/a[.="Accessories"]'
            )
        );
        $webDriver->getMouse()->mouseMove($element->getCoordinates());
        $webDriver->findElement(
            WebDriverBy::xpath(
                '//nav[@id="nav"]/descendant::li[contains(concat(" ",normalize-space(@class)," ")," level0 ")]'
                . '/a[.="Accessories"]/../descendant::li[contains(concat(" ",normalize-space(@class)," ")," level1 ")]'
                . '/a[.="Jewelry"]')
        )->click();

        $webDriver->findElement(
            WebDriverBy::xpath('//h2[@class="product-name"]/a[.="Blue Horizons Bracelets"]')
        )->click();

        self::assertContains('Blue Horizons Bracelets', $webDriver->getTitle());

        $webDriver->close();

    }

}