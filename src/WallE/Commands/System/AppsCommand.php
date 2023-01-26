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

use BadPixxel\PhpRobo\Robo\Tasks\Apps;
use BadPixxel\PhpRobo\Robo\Tasks\RoboTasksTrait;
use Robo\Exception\TaskException;
use Robo\Symfony\ConsoleIO;
use Robo\Tasks;

/**
 * Robo Commands to Install Applications
 */
class AppsCommand extends Tasks
{
    use RoboTasksTrait;

    /**
     * @command add:node-js
     *
     * @description Install Node JS
     *
     * @param null|string $version
     *
     * @throws TaskException
     *
     * @return int
     */
    public function installNodeJs(ConsoleIO $consoleIo, string $version = null): int
    {
        /** @var Apps\InstallNodeJsTask $task */
        $task = $this->taskInstallNodeJs($version);
        $result = $task
            ->detectVersion()
            ->askForVersion($consoleIo)
            ->run()
        ;
        $result->wasSuccessful()
            ? $consoleIo->success($result->getMessage())
            : $consoleIo->error($result->getMessage())
        ;

        return $result->getExitCode();
    }

    /**
     * @command add:yarn
     *
     * @description Install Yarn Package Manager
     *
     * @throws TaskException
     *
     * @return int
     */
    public function installYarn(ConsoleIO $consoleIo): int
    {
        /** @var Apps\InstallYarnTask $task */
        $task = $this->taskInstallYarn();

        $result = $task->run();
        $result->wasSuccessful()
            ? $consoleIo->success($result->getMessage())
            : $consoleIo->error($result->getMessage())
        ;

        return $result->getExitCode();
    }
}
