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

use Robo\Symfony\ConsoleIO;
use Robo\Task\Filesystem\FilesystemStack;
use Robo\Tasks;

/**
 * Install Current Executable on System
 */
class InstallCommand extends Tasks
{
    /**
     * @command wall-e:install
     *
     * @description Install BadPixxel Wall-E CLI as Default Command
     *
     * @return void
     */
    public function install(ConsoleIO $consoleIo)
    {
        /** @var FilesystemStack $fsStack */
        $fsStack = $this->taskFilesystemStack();
        //====================================================================//
        // Copy Executable
        $fsStack
            ->copy("bin/wall-e.phar", "/usr/local/bin/wall-e")
            ->chmod("/usr/local/bin/wall-e", 0755)
            ->run()
        ;
        //====================================================================//
        // verify Phar is packed correctly
        $this->_exec('wall-e');
        //====================================================================//
        // Notify User
        $consoleIo->success(
            "BadPixxel Wall-E CLI Installed. "
            ."Now uses 'wall-e list' to see all available commands"
        );
    }
}
