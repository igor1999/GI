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
namespace GI\DOM\HTML\Element\Input\Number;

use GI\DOM\HTML\Element\Input\AbstractInput;

class Range extends AbstractInput implements RangeInterface
{
    const TYPE = 'range';


    /**
     * @param int $min
     * @return static
     * @throws \Exception
     */
    public function setMin(int $min)
    {
        $this->getAttributes()->set('min', (int)$min);

        return $this;
    }

    /**
     * @param int $max
     * @return static
     * @throws \Exception
     */
    public function setMax(int $max)
    {
        $this->getAttributes()->set('max', (int)$max);

        return $this;
    }

    /**
     * @param int $step
     * @return static
     * @throws \Exception
     */
    public function setStep(int $step)
    {
        $this->getAttributes()->set('step', (int)$step);

        return $this;
    }
}