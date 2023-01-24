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

namespace BadPixxel\PhpRobo\Robo\Tools;

use Robo\Symfony\ConsoleIO;

trait AppComposerTrait
{
    /**
     * Force Using Composer Version
     *
     * @param ConsoleIO   $consoleIo Console Outputs
     * @param null|string $version   Requested Version (1, 2)
     *
     * @return void
     */
    protected function forceComposerVersion(ConsoleIO $consoleIo, string $version = null)
    {
        //====================================================================//
        // Safety Check
        if ($version && !in_array($version, array("1", "2"), true)) {
            $consoleIo->warning('Wrong Composer version. Should be null|1|2');
        }
        //====================================================================//
        // Safety Check
        if (in_array($version, array("1", "2"), true)) {
            $this->_exec(sprintf('composer self-update --%s;', $version));
        }
    }
}
