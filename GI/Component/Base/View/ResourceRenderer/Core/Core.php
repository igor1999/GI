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
namespace GI\Component\Base\View\ResourceRenderer\Core;

use GI\Component\Base\View\ResourceRenderer\AbstractResourceRenderer;

/**
 * Class Core
 * @package GI\Component\Base\View\ResourceRenderer\Core
 *
 * @method string getLoading()
 */
class Core extends AbstractResourceRenderer implements CoreInterface
{
    const URL_BASE_DIR = 'GI/Component/Base';


    const JS_PATHS = [
        'js/gi-client.js',
        'js/core/ajax/ajax.js',
        'js/core/ajax/sender.js',
        'js/core/ajax/configurator/abstract-configurator.js',
        'js/core/ajax/configurator/url-encoded.js',
        'js/core/ajax/configurator/json.js',
        'js/core/ajax/configurator/xml.js',
        'js/core/ajax/configurator/multipart.js',
        'js/core/cookie/cookie.js',
        'js/core/cookie/collection.js',
        'js/core/form.js',
        'js/core/text-processing.js',
        'js/core/widget/base.js',
        'js/core/widget/factory.js',
        'js/core/widget/repository.js',
        'js/core/widget/selector.js',
    ];

    const IMAGE_PATHS = [
        'loading' => 'img/loading.png',
    ];


    /**
     * Core constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createClassContents(self::class);

        $urlBase = $this->giCreateFSODir(self::URL_BASE_DIR);
        foreach (self::JS_PATHS as $js) {
            $key = $urlBase->createChildFile($js)->getPath();
            $this->get($key)->setCommentAsReplacement(false);
        }
    }
}