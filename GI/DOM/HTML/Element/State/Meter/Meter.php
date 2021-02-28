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
namespace GI\DOM\HTML\Element\State\Meter;

use GI\DOM\HTML\Element\State\Progress\Progress;

class Meter extends Progress implements MeterInterface
{
    const TAG = 'meter';


    /**
     * Meter constructor.
     * @param int $value
     * @throws \Exception
     */
    public function __construct(int $value)
    {
        parent::__construct();

        $this->setValue($value);
    }

    /**
     * @param int $min
     * @return static
     * @throws \Exception
     */
    public function setMin(int $min)
    {
        $this->getAttributes()->set('min', $min);

        return $this;
    }

    /**
     * @param int $low
     * @return static
     * @throws \Exception
     */
    public function setLow(int $low)
    {
        $this->getAttributes()->set('low', $low);

        return $this;
    }

    /**
     * @param int $high
     * @return static
     * @throws \Exception
     */
    public function setHigh(int $high)
    {
        $this->getAttributes()->set('high', $high);

        return $this;
    }

    /**
     * @param int $optimum
     * @return static
     * @throws \Exception
     */
    public function setOptimum(int $optimum)
    {
        $this->getAttributes()->set('optimum', $optimum);

        return $this;
    }
}