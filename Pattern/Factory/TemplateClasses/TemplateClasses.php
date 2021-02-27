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
namespace GI\Pattern\Factory\TemplateClasses;

use GI\Storage\Collection\StringCollection\ArrayList\Alterable\Alterable;
use GI\Storage\Collection\Behaviour\Option\StringCollection\ArrayList\ArrayList as Option;

class TemplateClasses extends Alterable implements TemplateClassesInterface
{
    /**
     * TemplateClasses constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $option = $this->createOption()->setUnique(true);

        parent::__construct([], $option);
    }

    /**
     * @return Option
     */
    protected function createOption()
    {
        return new Option();
    }

    /**
     * @param string $class
     * @return bool
     */
    public function validate(string $class)
    {
        $f = function($item) use ($class)
        {
            return is_a($class, $item, true);
        };

        return $this->isEmpty() || $this->containsByClosure($f);
    }
}