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
namespace GI\FileSystem\CSV;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\FileSystem\CSV\Exception\ExceptionAwareTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

abstract class AbstractCSV implements CSVInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    /**
     * @var FSOFileInterface
     */
    private $file;


    /**
     * AbstractCSV constructor.
     * @param FSOFileInterface $file
     */
    public function __construct(FSOFileInterface $file)
    {
        $this->file = $file;
    }

    /**
     * @return FSOFileInterface
     */
    public function getFile()
    {
        return $this->file;
    }
}