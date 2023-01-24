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

namespace BadPixxel\PhpRobo\WallE\Commands\Php;

use BadPixxel\PhpRobo\Robo\Tools\AppComposerTrait;
use Robo\Symfony\ConsoleIO;
use Robo\Tasks;

/**
 * PHP Apps Basic Commands
 */
class ComposerCommand extends Tasks
{
    use AppComposerTrait;

    /**
     * @command add:composer
     *
     * @description Install Composer
     *
     * @param null|string $version
     *
     * @return void
     */
    public function installComposer(ConsoleIO $consoleIo, string $version = null)
    {
        //====================================================================//
        // Create Temporary Path
        $tmpPath = $this->_tmpDir();
        //====================================================================//
        // Download Composer Installer
        $this->_copy("https://getcomposer.org/installer", $tmpPath."/composer-setup.php");
        //====================================================================//
        // Execute Install
        $this->_exec('php '.$tmpPath.'/composer-setup.php --install-dir=/usr/local/bin --filename=composer');
        //====================================================================//
        // Force Install of a Dedicated Version
        $this->forceComposerVersion($consoleIo, $version);
        //====================================================================//
        // Show Installed Version
        $this->_exec('composer --version');
        //====================================================================//
        // Notify User
        $consoleIo->success(
            sprintf("Composer %s Now Installed", $version ?? 'Latest')
        );
    }
}
