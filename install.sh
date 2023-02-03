#!/bin/sh
################################################################################
#
# Copyright (C) 2020 BadPixxel <www.badpixxel.com>
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
################################################################################

################################################################
# Download Latest version from Github
wget https://github.com/BadPixxel/Php-Robo/blob/main/bin/wall-e.phar?raw=true -O /usr/local/bin/wall-e
chmod +x /usr/local/bin/wall-e

################################################################
# Say hello
wall-e


