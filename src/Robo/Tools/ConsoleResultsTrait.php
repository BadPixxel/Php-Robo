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

trait ConsoleResultsTrait
{
    /**
     * Add a Result block of text.
     *
     * @param ConsoleIO $consoleIo
     * @param bool      $state
     * @param string    $messages
     *
     * @return void
     */
    protected function resultBlock(ConsoleIO $consoleIo, bool $state, string $messages)
    {
        $state
            ? $this->okBlock($consoleIo, $messages)
            : $this->koBlock($consoleIo, $messages)
        ;
    }

    /**
     * Add a Success Result block of text.
     *
     * @param ConsoleIO $consoleIo
     * @param string    $messages
     *
     * @return void
     */
    protected function okBlock(ConsoleIO $consoleIo, string $messages)
    {
        $consoleIo->writeln(sprintf('[<info> OK </info>] %s', $messages));
    }

    /**
     * Add an Error Result block of text.
     *
     * @param ConsoleIO $consoleIo
     * @param string    $messages
     *
     * @return void
     */
    protected function koBlock(ConsoleIO $consoleIo, string $messages)
    {
        $consoleIo->writeln(sprintf('[ <error>KO</error> ] %s', $messages));
    }

    /**
     * Add a Warning Result block of text.
     *
     * @param ConsoleIO $consoleIo
     * @param string    $messages
     *
     * @return void
     */
    protected function warBlock(ConsoleIO $consoleIo, string $messages)
    {
        $consoleIo->writeln(sprintf('[<comment>WARN</comment>] %s', $messages));
    }
}
