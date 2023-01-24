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

use Robo\Collection\CollectionBuilder;
use Robo\Task\Development\PackPhar;
use Symfony\Component\Finder\Finder;

trait PharBuilderTrait
{
    /**
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
}
