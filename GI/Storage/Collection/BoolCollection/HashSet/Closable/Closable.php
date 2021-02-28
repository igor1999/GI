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
namespace GI\Storage\Collection\BoolCollection\HashSet\Closable;

use GI\Storage\Collection\BoolCollection\HashSet\Alterable\Alterable;

use GI\Pattern\Closing\ClosingTrait;

class Closable extends Alterable implements ClosableInterface
{
    use ClosingTrait;


    /**
     * @param string $key
     * @param bool|null $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function set(string $key, bool $item = null, int $position = null)
    {
        $this->validateClosing();

        parent::set($key, $item);

        return $this;
    }

    /**
     * @param string $key
     * @param string $anchor
     * @param bool|null $item
     * @return static
     * @throws \Exception
     */
    public function insertBefore(string $key, string $anchor, bool $item = null)
    {
        $this->validateClosing();

        parent::insertBefore($key, $anchor, $item);

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function remove(string $key)
    {
        $this->validateClosing();

        return parent::remove($key);
    }

    /**
     * @param bool|null $needle
     * @return bool
     * @throws \Exception
     */
    public function removeItem(bool $needle = null)
    {
        $this->validateClosing();

        return parent::removeItem($needle);
    }

    /**
     * @param int $position
     * @return bool
     * @throws \Exception
     */
    public function removeByPosition(int $position)
    {
        $this->validateClosing();

        return parent::removeByPosition($position);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function pop()
    {
        $this->validateClosing();

        return parent::pop();
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function clean()
    {
        $this->validateClosing();

        parent::clean();

        return $this;
   }
}