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
namespace GI\Meta\CopyMaker\Contents;

use GI\Pattern\ArrayExchange\ArrayExchangeInterface;
use GI\Pattern\Validation\ValidationInterface;

interface ContentsInterface extends ArrayExchangeInterface, ValidationInterface
{
    /**
     * @return string
     */
    public function getClass();

    /**
     * @return string
     */
    public function getHash();

    /**
     * @return bool
     */
    public function isRegistered();

    /**
     * @return \Closure
     * @throws \Exception
     */
    public function getClassEncoder();

    /**
     * @param \Closure|null $classEncoder
     * @return static
     */
    public function setClassEncoder(\Closure $classEncoder = null);

    /**
     * @return \Closure
     * @throws \Exception
     */
    public function getClassDecoder();

    /**
     * @param \Closure|null $classDecoder
     * @return static
     */
    public function setClassDecoder(\Closure $classDecoder = null);

    /**
     * @param mixed $object
     * @return static
     * @throws \Exception
     */
    public function fill($object);

    /**
     * @return static
     */
    public function reset();

    /**
     * @param array $contents
     * @return static
     */
    public function resetAndHydrate(array $contents);
}