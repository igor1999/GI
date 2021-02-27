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
namespace GI\Storage\Collection\Behaviour\Option\Parts\Bounds\FloatBounds;

trait FloatBoundsTrait
{
    /**
     * @var float
     */
    private $min;

    /**
     * @var float
     */
    private $max;


    /**
     * @return float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param float|null $min
     * @return static
     */
    public function setMin(float $min = null)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param float|null $max
     * @return static
     */
    public function setMax(float $max = null)
    {
        $this->max = $max;

        return $this;
    }
}