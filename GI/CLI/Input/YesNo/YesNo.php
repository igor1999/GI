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
namespace GI\CLI\Input\YesNo;

use GI\CLI\Input\Simple\Simple;

class YesNo extends Simple implements YesNoInterface
{
    const DEFAULT_YES_VALUE = 'y';


    /**
     * @var string
     */
    private $yesValue = self::DEFAULT_YES_VALUE;


    /**
     * @return string
     */
    public function getYesValue()
    {
        return $this->yesValue;
    }

    /**
     * @param string $yesValue
     * @return static
     */
    public function setYesValue(string $yesValue)
    {
        $this->yesValue = $yesValue;

        return $this;
    }

    /**
     * @return bool|string
     * @throws \Exception
     */
    public function get()
    {
        return parent::get() == $this->yesValue;
    }
}