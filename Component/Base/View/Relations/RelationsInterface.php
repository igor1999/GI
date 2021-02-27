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
namespace GI\Component\Base\View\Relations;

use GI\Component\Base\View\ClientAttributes\ClientAttributesInterface;
use GI\Pattern\StringConvertable\StringConvertableInterface;

interface RelationsInterface extends StringConvertableInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return ClientAttributesInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return ClientAttributesInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return int
     */
    public function isEmpty();

    /**
     * @param string $key
     * @param ClientAttributesInterface $item
     * @return static
     * @throws \Exception
     */
    public function set(string $key, ClientAttributesInterface $item);

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key);

    /**
     * @return static
     */
    public function clean();

    /**
     * @return string
     * @throws \Exception
     */
    public function toString();
}