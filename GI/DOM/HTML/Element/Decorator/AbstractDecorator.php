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
namespace GI\DOM\HTML\Element\Decorator;

use GI\DOM\HTML\Element\ContainerElement;

abstract class AbstractDecorator extends ContainerElement implements DecoratorInterface
{
    const TAG = null;


    /**
     * AbstractDecorator constructor.
     * @param string $text
     * @throws \Exception
     */
    public function __construct(string $text = '')
    {
        parent::__construct(static::TAG);

        $this->getChildNodes()->set($text);
    }
}