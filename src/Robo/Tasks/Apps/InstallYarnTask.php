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

namespace BadPixxel\PhpRobo\Robo\Tasks\Apps;

use Robo\Common\TaskIO;
use Robo\Exception\TaskException;
use Robo\Result;
use Robo\Task\Base\ExecStack;
use Robo\Tasks;

/**
 * Robo Task to Install Yarn on a Server
 */
class InstallYarnTask extends Tasks implements \Robo\Contract\TaskInterface
{
    use TaskIO;

    /**
     * @inheritDoc
     *
     * @throws TaskException
     */
    public function run()
    {
        //====================================================================//
        // Check if Yarn Already Installed
        /** @var ExecStack $execStack */
        $execStack = $this->taskExecStack();
        $result = $execStack
            ->silent(true)
            ->setVerbosityThreshold(3)
            ->exec("apt list -i -q | grep yarn")
            ->run()
        ;
        if (!empty($result->getOutputData())) {
            return Result::success($this, "Yarn Already Installed");
        }
        //====================================================================//
        // Install Yarn
        /** @var ExecStack $execStack */
        $execStack = $this->taskExecStack();
        $result = $execStack
            ->detectInteractive()
            ->setVerbosityThreshold(3)
            ->silent(true)
            ->exec("apt install curl -y")
            ->exec(
                "curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg"
                ." | gpg --dearmor | tee /usr/share/keyrings/yarnkey.gpg >/dev/null"
            )
            ->exec(
                'echo "deb [signed-by=/usr/share/keyrings/yarnkey.gpg]'
                .' https://dl.yarnpkg.com/debian stable main"'
                .' | tee /etc/apt/sources.list.d/yarn.list'
            )
            ->exec("apt update && apt install yarn -y")
            ->exec("yarn --version")
            ->run()
        ;
        if (!$result->wasSuccessful()) {
            return Result::error($this, "Unable to Install Yarn");
        }

        return Result::success($this, "Yarn Now Installed");
    }
}
