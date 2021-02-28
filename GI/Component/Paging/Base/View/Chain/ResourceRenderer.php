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
namespace GI\Component\Paging\Base\View\Chain;

use GI\Component\Paging\Base\View\Base\AbstractResourceRenderer;

class ResourceRenderer extends AbstractResourceRenderer implements ResourceRendererInterface
{
    const URL_BASE_DIR = 'GI/Component/Paging/Chain';


    const CSS_PATHS = [
        'css/chain.css',
    ];

    const JS_PATHS = [
        'js/chain.js',
        'js/factory.js',
    ];


    /**
     * AbstractResourceRenderer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->createContents(
            self::class, '', self::URL_BASE_DIR,self::CSS_PATHS, self::JS_PATHS
        );
    }
}