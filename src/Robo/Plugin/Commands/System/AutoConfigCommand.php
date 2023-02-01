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

namespace BadPixxel\WallE\Robo\Plugin\Commands\System;

use BadPixxel\Robo\Extras\Console\ResultsBlock;
use BadPixxel\Robo\NodeJs\NodeJsTasksTrait;
use BadPixxel\Robo\NodeJs\YarnTasksTrait;
use Robo\Exception\TaskException;
use Robo\Result;
use Robo\Symfony\ConsoleIO;
use Robo\Tasks;

class AutoConfigCommand extends Tasks
{
    use NodeJsTasksTrait;
    use YarnTasksTrait;

    /**
     * @command auto
     *
     * @description Automatically Configure Local System
     *
     * @throws TaskException
     */
    public function autoConfigure(ConsoleIO $consoleIo): int
    {
        $consoleIo->title("Wall-E - Auto Config Script");
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
            $block = new ResultsBlock($consoleIo);
            $block->result($result->wasSuccessful(), $result->getMessage());
        }

        return $this;
    }
}
