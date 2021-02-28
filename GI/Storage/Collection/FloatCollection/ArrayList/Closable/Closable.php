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
namespace GI\Storage\Collection\FloatCollection\ArrayList\Closable;

use GI\Storage\Collection\FloatCollection\ArrayList\Alterable\Alterable;

use GI\Pattern\Closing\ClosingTrait;

class Closable extends Alterable implements ClosableInterface
{
    use ClosingTrait;


    /**
     * @param float $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function add(float $item, int $position = null)
    {
        $this->validateClosing();

        parent::add($item);

        return $this;
    }

    /**
     * @param int $index
     * @return bool
     * @throws \Exception
     */
    public function remove(int $index)
    {
        $this->validateClosing();

        return parent::remove($index);
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
     * @param float $needle
     * @return bool
     * @throws \Exception
     */
    public function removeItem(float $needle)
    {
        $this->validateClosing();

        return parent::removeItem($needle);
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