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

namespace BadPixxel\WallE\Robo\Plugin\Commands\WallE;

use Robo\Symfony\ConsoleIO;
use Robo\Task\Filesystem\FilesystemStack;
use Robo\Tasks;

/**
 * Install Current Executable on System
 */
class InstallCommand extends Tasks
{
    /**
     * @command self:install
     *
     * @description Install BadPixxel Wall-E CLI as Default Command
     *
     * @return void
     */
    public function install(ConsoleIO $consoleIo)
    {
        /** @var FilesystemStack $fsStack */
        $fsStack = $this->taskFilesystemStack();
        $fsStack->setVerbosityThreshold(3);
        //====================================================================//
        // Copy Executable
        $taskResult = $fsStack
            ->copy("bin/wall-e.phar", "/usr/local/bin/wall-e")
            ->chmod("/usr/local/bin/wall-e", 0755)
            ->run()
        ;
        if (!$taskResult->wasSuccessful()) {
            $consoleIo->error("BadPixxel Wall-E CLI Install Fail.");

            return;
        }
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

    /**
     * @command self:zsh
     *
     * @description Install BadPixxel Wall-E CLI as Zsh Allias
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function installZsh(ConsoleIO $consoleIo)
    {
        /** @var FilesystemStack $fsStack */
        $fsStack = $this->taskFilesystemStack();
        $fsStack->setVerbosityThreshold(3);
        //====================================================================//
        // Deploy Zsh Custom Script
        $home = $_SERVER['HOME'];
        if ($home && is_dir($home."/.oh-my-zsh")) {
            $taskResult = $fsStack
                ->mkdir($home."/.oh-my-zsh/custom")
                ->copy("./src/Resources/Zsh/wall-e.zsh", $home."/.oh-my-zsh/custom/wall-e.zsh")
                ->run()
            ;
            if ($taskResult->wasSuccessful()) {
                $consoleIo->success("BadPixxel Wall-E Zsh Allias Installed.");
            }
        }
    }
}
