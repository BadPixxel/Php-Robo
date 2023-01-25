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
use Robo\Task\Base\Exec;

trait AppGrumphpTraitTrait
{
    /**
     * @var string
     */
    private $prefix = "./";

    /**
     * Identify Grumphp Location
     *
     * @param ConsoleIO $consoleIo Console Outputs
     *
     * @return null|string
     */
    protected function getGrumphpPath(ConsoleIO $consoleIo): ?string
    {
        $paths = array(
            "bin/grumphp",
            "vendor/bin/grumphp",
        );
        //====================================================================//
        // Walk on Possible Path
        foreach ($paths as $path) {
            if (is_file($this->prefix.$path)) {
                return $this->prefix.$path;
            }
        }
        $consoleIo->error('Unable to find Grumphp Binaries');

        return null;
    }

    /**
     * Execute a Complete Grumphp Tests Suite
     *
     * @param ConsoleIO             $consoleIo
     * @param null|string           $path
     * @param array<string, string> $tasks
     * @param string                $name
     *
     * @return bool
     */
    protected function execGrumpSuite(
        ConsoleIO $consoleIo,
        ?string $path,
        array $tasks,
        string $name = "Tests Suite"
    ): bool {
        //====================================================================//
        // Setup
        if ($path) {
            $this->setGrumphpPathPrefix($path);
        }
        //====================================================================//
        // Execute Tasks
        $results = $this->execGrumpTasks($consoleIo, $tasks);
        //====================================================================//
        // Render Results
        $consoleIo->section("Grumphp ".$name);
        foreach ($tasks as $code => $desc) {
            $this->resultBlock($consoleIo, !empty($results[$code]), $desc);
        }
        //====================================================================//
        // Notify User
        if (count($tasks) == count(array_filter($results))) {
            $consoleIo->success("Grumphp ".$name." Passed");

            return true;
        }
        $consoleIo->error("Grumphp ".$name." Fail");

        return false;
    }

    /**
     * Execute Grumphp Tests (No Outputs)
     *
     * @param ConsoleIO             $consoleIo
     * @param array<string, string> $tasks
     *
     * @return array<string, bool>
     */
    protected function execGrumpTasks(ConsoleIO $consoleIo, array $tasks): array
    {
        //====================================================================//
        // Find Binary
        $grumpPath = $this->getGrumphpPath($consoleIo);
        if (!$grumpPath) {
            return array_map(function () {
                return false;
            }, $tasks);
        }

        $isCliMode = empty(getenv('CI'));
        if ($isCliMode) {
            $progressBar = $consoleIo->createProgressBar(count($tasks));
        }
        //====================================================================//
        // Executes Tasks
        $results = array();
        foreach (array_keys($tasks) as $code) {
            //====================================================================//
            // Build Task Command
            $command = sprintf("php %s run --tasks=%s", $grumpPath, $code);
            if ($consoleIo->isQuiet()) {
                $command .= " -q";
            }
            //====================================================================//
            // Execute Task
            /** @var Exec $taskExec */
            $taskExec = $this->taskExec($command." -q -n");
            $results[$code] = $taskExec
                ->silent(true)
                ->printOutput(false)
                ->run()
                ->wasSuccessful()
            ;
            //====================================================================//
            // Task Fail => Redo with Outputs
            if (!$results[$code]) {
                $this->taskExec($command)->run();
            }
            if ($isCliMode) {
                $progressBar->advance();
            }
        }
        if ($isCliMode) {
            $progressBar->clear();
        }

        return $results;
    }

    /**
     * Set Grumphp Location Prefix
     *
     * @param string $prefix Force Path Prefix
     *
     * @return $this
     */
    protected function setGrumphpPathPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }
}
