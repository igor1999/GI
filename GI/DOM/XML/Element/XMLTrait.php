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
namespace GI\DOM\XML\Element;

use GI\DOM\XML\Attributes\Attributes;
use GI\Markup\Constants;

use GI\DOM\XML\Attributes\AttributesInterface;

trait XMLTrait
{
    /**
     * @var AttributesInterface
     */
    private $attributes;

    /**
     * @var string
     */
    private $namespace = '';


    /**
     * @return static
     */
    protected function createAttributes()
    {
        $this->attributes = $this->giGetDi(AttributesInterface::class, Attributes::class);

        return $this;
    }

    /**
     * @return AttributesInterface
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return bool
     */
    public function hasNamespace()
    {
        return !empty($this->namespace);
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getFullTag()
    {
         return  $this->hasNamespace() && $this->hasTag()
            ? $this->namespace . Constants::XMLNS_SEPARATOR . $this->getTag()
            : $this->getTag();
    }
}