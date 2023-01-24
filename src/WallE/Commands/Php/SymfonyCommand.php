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

use Robo\Symfony\ConsoleIO;
use Robo\Tasks;

class SymfonyCommand extends Tasks
{
    /**
     * @command Symfony:configure
     *
     * @description Configure Symfony Application
     *
     * @return void
     */
    public function configure(ConsoleIO $consoleIo)
    {
        //====================================================================//
        // Notify User
        $consoleIo->success("Symfony App Now Configured");
    }
}
