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
namespace GI\CLI\CommandLine\Argument;

use GI\Pattern\Closing\ClosingInterface;
use GI\Pattern\StringConvertable\StringConvertableInterface;

interface ArgumentInterface extends  ClosingInterface, StringConvertableInterface
{
    const NAMED_ARGUMENT_PREFIX    = '@';

    const BASE_64_MARK             = '(64)';

    const NAMED_ARGUMENT_SEPARATOR = '=';


    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param string $value
     * @return static
     * @throws \Exception
     */
    public function setValue(string $value);

    /**
     * @return bool
     */
    public function isNamed();

    /**
     * @return bool
     */
    public function isBase64();

    /**
     * @param bool $base64
     * @return static
     */
    public function setBase64(bool $base64);

    /**
     * @param string $raw
     * @return static
     * @throws \Exception
     */
    public function read(string $raw);
}