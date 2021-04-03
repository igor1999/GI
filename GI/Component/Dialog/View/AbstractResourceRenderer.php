<?php
/*
 * This file is part of PHP-framework GI.
 *
 * PHP-framework GI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP-framework GI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP-framework GI. If not, see <https://www.gnu.org/licenses/>.
 */
namespace GI\Component\Dialog\View;

use GI\Component\Base\View\ResourceRenderer\Core\Core;

abstract class AbstractResourceRenderer extends Core implements ResourceRendererInterface
{
    const URL_BASE_DIR = 'GI/Component/Dialog';


    const CSS_PATHS = [
        'css/dialog.css',
    ];

    const JS_PATHS = [
        'js/dialog.js',
    ];

    const IMAGE_PATHS = [
        'img/close-active.png',
        'img/close-inactive.png',
        'img/opacity.png',
        'img/win-resize.png',
    ];


    /**
     * AbstractResourceRenderer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->createClassContents(self::class);
    }
}