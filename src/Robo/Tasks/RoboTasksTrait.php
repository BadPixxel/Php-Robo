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

namespace BadPixxel\PhpRobo\Robo\Tasks;

use Robo\Collection\CollectionBuilder;
use Robo\Exception\TaskException;
use Robo\Result;

/**
 * Add Generic Robo Tasks to Wall-E
 */
trait RoboTasksTrait
{
    /**
     * Install Node JS
     *
     * @param null|string $version
     *
     * @return CollectionBuilder
     */
    protected function taskInstallNodeJs(string $version = null): CollectionBuilder
    {
        return $this->task(Apps\InstallNodeJsTask::class, $version);
    }

    /**
     * Install Yarn
     *
     * @return CollectionBuilder
     */
    protected function taskInstallYarn(): CollectionBuilder
    {
        return $this->task(Apps\InstallYarnTask::class);
    }

    /**
     * Automated Node Js Install
     *
     * @throws TaskException
     *
     * @return Result
     */
    private function autoConfigNodeJs(): Result
    {
        /** @var Apps\InstallNodeJsTask $task */
        $task = $this->taskInstallNodeJs();

        return $task
            ->detectVersion()
            ->setRequired(false)
            ->run()
        ;
    }

    /**
     * Automated Yarn Install
     *
     * @throws TaskException
     *
     * @return Result
     */
    private function autoConfigYarn(): Result
    {
        /** @var Apps\InstallYarnTask $task */
        $task = $this->taskInstallYarn();

        return empty(getenv("YARN_VERSION"))
            ? Result::success($task)
            : $task->run()
        ;
    }
}
