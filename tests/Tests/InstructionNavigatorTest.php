<?php

namespace Nomad\Tests;

use Magium\Navigators\InstructionNavigator;

class InstructionNavigatorTest extends AbstractTestCase
{

    public function testLookAtHowGreatInstructionNavigatorsAre()
    {
        $this->commandOpen($this->getTheme()->getBaseUrl());
        $xpaths = [
            '//nav[@id="nav"]/descendant::li[contains(@class, "level0")]/a[.="Women"]',
            '//nav[@id="nav"]/descendant::li[contains(@class, "level0")]/a[.="Men"]',
            '//nav[@id="nav"]/descendant::li[contains(@class, "level0")]/a[.="Accessories"]',
            '//nav[@id="nav"]/descendant::li[contains(@class, "level0")]/a[.="Home & Decor"]',
        ];

        $instructions = [];

        foreach ($xpaths as $path) {
            $instructions[] = [InstructionNavigator::INSTRUCTION_MOUSE_MOVETO, $path];
            $instructions[] = [InstructionNavigator::INSTRUCTION_PAUSE, 3];
        }

        $this->getNavigator(InstructionNavigator::NAVIGATOR)->navigateTo($instructions);

    }


}