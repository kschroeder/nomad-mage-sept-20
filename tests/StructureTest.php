<?php

namespace Examples;

use Facebook\WebDriver\WebDriverBy;
use Magium\AbstractTestCase;

class StructureTest extends AbstractTestCase
{

    /**
     *
     * As a website customer I want to see the hidden message when i click the Click Me button
     *
     */

    public function testLookHowEasyIDsAre()
    {
        $hidden = $this->webdriver->findElement(WebDriverBy::id('hidden-element'));
        self::assertFalse($hidden->isDisplayed());

        $this->webdriver->findElement(WebDriverBy::id('click-me'))->click();

        self::assertTrue($hidden->isDisplayed());
    }

    /**
     *
     * As a website customer I want to see all of Kevin's public Twitter accounts
     *
     */

    public function testIHaveThreeTwitterAccounts()
    {
        $xpath = $this->concatClass('//td[%s]', 'twitter-screen-name');
        $elements = $this->webdriver->findElements(WebDriverBy::xpath($xpath));
        self::assertCount(3, $elements);
    }

    /**
     *
     * As a pedantic software consultant I want to prove my point
     *
     */

    public function testOrphanedUnpredictableText()
    {
        $this->setExpectedException('Facebook\WebDriver\Exception\NoSuchElementException');
        $this->webdriver->findElement(WebDriverBy::xpath('//p[.="The number "]'));
    }




    // helper functionality

    protected function setUp()
    {
        parent::setUp();
        $path = 'file://' . realpath('structure.html');
        $this->commandOpen($path);
    }

    protected function concatClass($xpath, $class)
    {
        // Yes, this should be in a baser abstract test class so I can reuse it.
        $concat = sprintf('contains(concat(" ",normalize-space(@class)," ")," %s ")', $class);
        return sprintf($xpath, $concat);
    }

}