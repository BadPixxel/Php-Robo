#!/usr/bin/env php
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

// If we're running from phar load the phar autoload file.
$pharPath = \Phar::running(true);
if ($pharPath) {
    $autoloaderPath = "{$pharPath}/vendor/autoload.php";
} else {
    //====================================================================//
    // If we're NOT running from phar load the vendor autoload file.
    if (file_exists(__DIR__.'/vendor/autoload.php')) {
        $autoloaderPath = __DIR__.'/vendor/autoload.php';
    } elseif (file_exists(__DIR__.'/../../autoload.php')) {
        $autoloaderPath = __DIR__.'/../../autoload.php';
    } else {
        die("Could not find autoloader. Run 'composer install'.");
    }
}
$classLoader = require $autoloaderPath;

//====================================================================//
// Customization variables
$appName = "Wall-e - BadPixxel CLI";
$appVersion = trim((string) file_get_contents(__DIR__.'/VERSION'));
$selfUpdateRepository = 'badpixxel/php-cli';
$configurationFilename = '.bp-config.yml';
//====================================================================//
// Define our Robo Runner
$runner = new \Robo\Runner();
$runner
    // Auto-Discover Robo Commands
    ->setRelativePluginNamespace('WallE')
    // Repository for Self Update
    ->setSelfUpdateRepository($selfUpdateRepository)
    // Local Configuration
    ->setConfigurationFilename($configurationFilename)
    // Register Class Loader
    ->setClassLoader($classLoader)
;
//====================================================================//
// Detect CI/CD Environment
if (getenv('CI')) {
    $argv = array_merge($argv, array("--ansi"));
}
//====================================================================//
// Execute the command
$output = new \Symfony\Component\Console\Output\ConsoleOutput();
$statusCode = $runner->execute($argv, $appName, $appVersion, $output);
//====================================================================//
// Return the result.
exit($statusCode);
