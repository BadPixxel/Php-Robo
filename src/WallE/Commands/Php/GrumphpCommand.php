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

use BadPixxel\PhpRobo\Robo\Tools\AppGrumphpTraitTrait;
use BadPixxel\PhpRobo\Robo\Tools\ConsoleResultsTrait;
use Robo\Symfony\ConsoleIO;
use Robo\Tasks;

class GrumphpCommand extends Tasks
{
    use ConsoleResultsTrait;
    use AppGrumphpTraitTrait;

    /** @var string[] */
    const QUALITY_TASKS = array(
        "composer" => "Composer => Check Dependencies Status",
        "phplint" => "PhpLint => Verify PHP Code Syntax vs PHP Version",
        "jsonlint" => "JsonLint => Verify Json Files Syntax",
        "xmllint" => "XmlLint => Verify Xml Files Syntax",
        "yamllint" => "YamlLint => Verify Yaml Files Syntax",
        "twigcslint" => "TwigCsLint => Verify Twig Files Syntax",
        "phpcpd" => "PhpCpd => Search for Duplicate pieces of Code",
        "phpcs" => "Php CS => Verify Code Styling",
        "phpmd" => "PHP MD => Mess Detector",
        "phpcsfixer" => "PHP CS Fixer => Automatic CS Fixing"
    );

    /** @var string[] */
    const PHPSTAN_TASKS = array(
        "phpstan" => "Phpstan => PHP Code Static Analyze",
    );

    /**
     * @command grumphp:quality
     *
     * @description Execute GrumpPhp Quality Standards Verifications
     *
     * @param null|string $path Force Path Prefix
     *
     * @return void
     */
    public function quality(ConsoleIO $consoleIo, string $path = null)
    {
        $this->execGrumpSuite(
            $consoleIo,
            $path,
            self::QUALITY_TASKS,
            "Quality Standards"
        );
    }

    /**
     * @command grumphp:stan
     *
     * @description Execute GrumpPhp PhpStan Verifications
     *
     * @param null|string $path Force Path Prefix
     *
     * @return void
     */
    public function stan(ConsoleIO $consoleIo, string $path = null)
    {
        $this->execGrumpSuite(
            $consoleIo,
            $path,
            self::PHPSTAN_TASKS,
            "PhpStan"
        );
    }

    /**
     * @command grumphp:full
     *
     * @description Execute GrumpPhp Full Verifications
     *
     * @param null|string $path Force Path Prefix
     *
     * @return void
     */
    public function full(ConsoleIO $consoleIo, string $path = null)
    {
        $this->execGrumpSuite(
            $consoleIo,
            $path,
            array_merge(self::QUALITY_TASKS, self::PHPSTAN_TASKS),
            "Full Test Suite"
        );
    }
}
