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
use Robo\Contract\TaskInterface;
use Robo\Exception\TaskException;
use Robo\Result;
use Robo\Symfony\ConsoleIO;
use Robo\Task\Base\ExecStack;
use Robo\Tasks;

/**
 * Robo Task to Install Node JS on a Server
 */
class InstallNodeJsTask extends Tasks implements TaskInterface
{
    use TaskIO;

    /**
     * Default Node JS Version
     */
    const DEFAULT_VERSION = 16;

    /**
     * Node JS Allowed Version
     */
    const VERSIONS = array("12", "14", "16", "18");

    /**
     * @var null|string
     */
    private ?string $version;

    /**
     * @var bool
     */
    private bool $required;

    /**
     * @param null|string $version
     */
    public function __construct(?string $version = null)
    {
        $this->version = $version;
    }

    /**
     * @inheritDoc
     *
     * @throws TaskException
     */
    public function run(): Result
    {
        //====================================================================//
        // Ensure Version
        if (empty($this->version)) {
            return $this->required
                ? Result::error($this, "No NodeJs Version Defined")
                : Result::success($this, "")
            ;
        }
        //====================================================================//
        // Install Node JS Version
        /** @var ExecStack $execStack */
        $execStack = $this->taskExecStack();
        $result = $execStack
            ->setVerbosityThreshold(3)
            ->silent(true)
            ->exec("apt install curl -y")
            ->exec("apt remove nodejs -y")
            ->exec(sprintf(
                "curl -fsSL https://deb.nodesource.com/setup_%s.x | bash",
                $this->version
            ))
            ->exec("apt update && apt install nodejs -y")
            ->exec("node --version")
            ->run()
        ;
        if (!$result->wasSuccessful()) {
            return Result::error($this, "Unable to Install NodeJs");
        }

        return Result::success($this, sprintf("NodeJs V%s Installed", $this->version));
    }

    /**
     * Mark Install as Required
     *
     * @return $this
     */
    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Detect Version to Install via ENV Variables
     *
     * @return $this
     */
    public function detectVersion(): self
    {
        if (!empty($this->version)) {
            return $this;
        }

        $version = getenv("NODEJS_VERSION");
        if ($version && is_string($version)) {
            $this->version = $version;
        }

        return $this;
    }

    /**
     * Ask User for Version to Install
     *
     * @param ConsoleIO $consoleIo
     *
     * @return $this
     */
    public function askForVersion(ConsoleIO $consoleIo): self
    {
        if (!empty($this->version)) {
            return $this;
        }
        $version = $consoleIo->choice(
            "Select Node Js Version",
            self::VERSIONS,
            self::DEFAULT_VERSION
        );
        if ($version && is_string($version)) {
            $this->version = $version;
        }

        return $this;
    }
}
