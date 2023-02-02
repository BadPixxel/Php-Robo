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

namespace BadPixxel\WallE\Robo\Plugin\Commands\WallE;

use Robo\Collection\CollectionBuilder;
use Robo\Symfony\ConsoleIO;
use Robo\Task\Composer\Install;
use Robo\Task\Development\PackPhar;
use Robo\Task\Filesystem\FilesystemStack;
use Robo\Tasks;
use Symfony\Component\Finder\Finder;

/**
 * Build Wall-E Executable
 */
class BuildCommand extends Tasks
{
    const SRC_FILE = "wall-e.php";
    const BUILD_FILE = "wall-e.phar";

    /**
     * @command self:build
     *
     * @description Build BadPixxel Wall-E CLI
     *
     * @return void
     */
    public function build(ConsoleIO $consoleIo)
    {
        //====================================================================//
        // Create Temporary Path
        $tmpPath = $this->_tmpDir();
        //====================================================================//
        // Create Composer Project
        /** @var FilesystemStack $fsStack */
        $fsStack = $this->taskFilesystemStack();
        $fsStack
            ->copy("./composer.json", $tmpPath."/composer.json")
            ->mirror("./src", $tmpPath."/src")
            ->run()
        ;
        //====================================================================//
        // Execute Composer Install
        /** @var Install $composer */
        $composer = $this->taskComposerInstall();
        $composer
            ->workingDir($tmpPath)
            ->noDev()
            ->noInteraction()
            ->noSuggest()
            ->disablePlugins()
            ->preferDist()
            ->run()
        ;
        //====================================================================//
        // Create Robo Binary
        /** @var PackPhar $pharTask */
        $pharTask = $this->taskPackPhar('bin/'.self::BUILD_FILE);
        $pharTask
            ->compress()
            ->stub('./src/WallE/stub.php')
        ;
        //====================================================================//
        // Add Files Binary
        $pharTask->addFile(self::SRC_FILE, self::SRC_FILE);
        $pharTask->addFile("VERSION", "VERSION");
        /** @var CollectionBuilder $pharTask */
        $this->addPhpFiles($pharTask, './src', 'src/');
        $this->addPhpFiles($pharTask, $tmpPath.'/vendor', 'vendor/');
        $this->addExtraFolders($pharTask, $tmpPath.'/vendor', 'vendor/');
        //====================================================================//
        // Build Final Binary
        $pharTask->run();
        //====================================================================//
        // verify Phar is packed correctly
        $this->_exec('php bin/'.self::BUILD_FILE);
        //====================================================================//
        // Notify User
        $consoleIo->success(sprintf(
            "BadPixxel Wall-E CLI Build done in %s",
            'bin/'.self::BUILD_FILE
        ));
    }

    /**
     * Add all PHP Files to Phar Archive
     *
     * @param CollectionBuilder $pharTask
     * @param string            $src
     * @param string            $dest
     *
     * @return void
     */
    protected function addPhpFiles(CollectionBuilder $pharTask, string $src, string $dest): void
    {
        /** @var PackPhar $pharTask */
        $finder = Finder::create()
            ->name('*.php')
            ->in($src)
        ;
        foreach ($finder as $file) {
            $pharTask->addFile($dest.$file->getRelativePathname(), $file->getRealPath());
        }
    }

    /**
     * Add any Extra folder to Phar Archive
     *
     * @param CollectionBuilder $pharTask
     * @param string            $src
     * @param string            $dest
     *
     * @return void
     */
    protected function addExtraFolders(CollectionBuilder $pharTask, string $src, string $dest): void
    {
        /** @var PackPhar $pharTask */
        $finder = Finder::create()
            ->name('.phar-keep')
            ->in($src)
            ->ignoreDotFiles(false)
        ;

        foreach ($finder as $keepFile) {
            $pharTask->addFile($dest.$keepFile->getRelativePathname(), $keepFile->getRealPath());
            $keepDir = dirname($keepFile->getRealPath());
            $keepDirRelative = dirname($keepFile->getRelativePathname())."/";
            foreach (Finder::create()->in($keepDir)->files() as $file) {
                $pharTask->addFile($dest.$keepDirRelative.$file->getRelativePathname(), $file->getRealPath());
            }
        }
    }
}
