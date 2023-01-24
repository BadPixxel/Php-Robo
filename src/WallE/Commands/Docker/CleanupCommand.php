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

namespace BadPixxel\PhpRobo\WallE\Commands\Docker;

use BadPixxel\PhpRobo\Robo\Tools\AppComposerTrait;
use Robo\Exception\TaskException;
use Robo\Symfony\ConsoleIO;
use Robo\Task\Base\ExecStack;
use Robo\Tasks;

/**
 * Docker CleanUp  Commands
 */
class CleanupCommand extends Tasks
{
    use AppComposerTrait;

    /**
     * @command docker:clear
     *
     * @description Delete All Docker Unused Images & Volumes
     *
     * @throws TaskException
     *
     * @return void
     */
    public function clearDocker(ConsoleIO $consoleIo)
    {
        //====================================================================//
        // Show Installed Version
        /** @var ExecStack $execStack */
        $execStack = $this->taskExecStack();
        $result = $execStack
            ->stopOnFail()
            ->exec('docker image prune -a -f')
            ->exec('docker volume prune -f')
            ->run()
        ;
        //====================================================================//
        // Notify User
        if ($result->wasSuccessful()) {
            $consoleIo->success("All Docker Unused Images & Volumes have been cleaned");
        }
    }
}
