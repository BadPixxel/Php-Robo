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

namespace BadPixxel\WallE\Robo\Plugin\Commands\Docker;

use Robo\Exception\TaskException;
use Robo\Symfony\ConsoleIO;
use Robo\Task\Base\ExecStack;
use Robo\Tasks;

/**
 * Install Docker via Apt
 */
class AptInstallCommand extends Tasks
{
    /**
     * @command add:docker
     *
     * @description Install Docker via APT
     *
     * @throws TaskException
     *
     * @return void
     */
    public function dockerAptInstall(ConsoleIO $consoleIo)
    {
        //====================================================================//
        // Show Installed Version
        /** @var ExecStack $execStack */
        $execStack = $this->taskExecStack();
        $result = $execStack
            ->stopOnFail()
            ->exec('apt update')
            ->exec('apt -y install ca-certificates curl gnupg lsb-release')
            ->exec('curl -fsSL https://get.docker.com | sh')
            ->exec('docker --version')
            ->run()
        ;
        //====================================================================//
        // Notify User
        if ($result->wasSuccessful()) {
            $consoleIo->success("Docker Now Installed");
        }
    }
}
