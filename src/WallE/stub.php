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

Phar::mapPhar('wall-e.phar');

$application = require_once 'phar://wall-e.phar/wall-e.php';
$application->setPharMode(true);
$application->run();

//__HALT_COMPILER();
