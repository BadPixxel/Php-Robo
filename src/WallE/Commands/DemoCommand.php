<?php

/*
 *  Copyright (C) BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\PhpRobo\WallE\Commands;

use BadPixxel\PhpRobo\Robo\Tools\ConsoleResultsTrait;
use Robo\Symfony\ConsoleIO;
use Robo\Tasks;

/**
 * Bash Outputs Tests & Démo
 */
class DemoCommand extends Tasks
{
    use ConsoleResultsTrait;

    /**
     * @command wall-e:demo
     *
     * @description Bash Outputs Tests & Démo
     *
     * @return void
     */
    public function demo(ConsoleIO $consoleIo)
    {
        //====================================================================//
        // Simple Notifications
        $consoleIo->error("This is an Error!");
        $consoleIo->success("This is a Success!");
        //====================================================================//
        // Task Results
        $consoleIo->title("This is My Title!");
        $this->resultBlock($consoleIo, true, "This task worked");
        $this->resultBlock($consoleIo, false, "This task fail");
    }
}
