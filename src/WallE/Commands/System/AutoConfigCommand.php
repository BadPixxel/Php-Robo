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

namespace BadPixxel\PhpRobo\WallE\Commands\System;

use BadPixxel\PhpRobo\Robo\Tasks\RoboTasksTrait;
use BadPixxel\PhpRobo\Robo\Tools\ConsoleResultsTrait;
use Robo\Exception\TaskException;
use Robo\Result;
use Robo\Symfony\ConsoleIO;
use Robo\Tasks;

class AutoConfigCommand extends Tasks
{
    use RoboTasksTrait;
    use ConsoleResultsTrait;

    /**
     * @command auto
     *
     * @description Automatically Configure Local System
     *
     * @throws TaskException
     */
    public function autoConfigure(ConsoleIO $consoleIo): int
    {
        //====================================================================//
        // Install Node JS
        $this->appendResult($consoleIo, $this->autoConfigNodeJs());
        //====================================================================//
        // Install Yarn
        $this->appendResult($consoleIo, $this->autoConfigYarn());

        return 0;
    }

    /**
     * Append Automated Action result to Console Log
     *
     * @param ConsoleIO $consoleIo
     * @param Result    $result
     *
     * @return $this
     */
    private function appendResult(ConsoleIO $consoleIo, Result $result): self
    {
        if (!empty($result->getMessage())) {
            $this->resultBlock($consoleIo, $result->wasSuccessful(), $result->getMessage());
        }

        return $this;
    }
}
