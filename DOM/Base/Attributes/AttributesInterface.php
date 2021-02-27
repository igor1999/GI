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
namespace GI\DOM\Base\Attributes;

use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\AlterableInterface as BaseInterface;
use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\Util\TextProcessing\Escaper\EscaperInterface;
use GI\Storage\Collection\ScalarCollection\HashSet\Immutable\ImmutableInterface as ScalarHashSetInterface;
use GI\Storage\Collection\StringCollection\ArrayList\Alterable\AlterableInterface as StringArrayListInterface;

interface AttributesInterface extends BaseInterface, StringConvertableInterface
{
    /**
     * @return ScalarHashSetInterface
     */
    public function getConstantAttributes();

    /**
     * @param string $key
     * @param string|bool $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function set(string $key, $item, int $position = null);

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function remove(string $key);

    /**
     * @return StringArrayListInterface
     */
    public function getEscapedAttributes();

    /**
     * @return EscaperInterface
     */
    public function getEscaper();
}