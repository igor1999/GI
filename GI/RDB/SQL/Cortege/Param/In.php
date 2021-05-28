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
namespace GI\RDB\SQL\Cortege\Param;

use GI\Storage\Collection\StringCollection\ArrayList\Immutable\ImmutableInterface;

class In extends Param implements InInterface
{
    const DEFAULT_PREFIX = 'in_';

    const DEFAULT_ALT    = '\'\'';


    /**
     * @var ImmutableInterface
     */
    private $rawSource;

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * @var string
     */
    private $alt = '';


    /**
     * In constructor.
     * @param array $rawSource
     * @param string|null $prefix
     * @param string|null $alt
     * @throws \Exception
     */
    public function __construct(array $rawSource, string $prefix = null, string $alt = null)
    {
        $this->rawSource = $this->getGiServiceLocator()->getStorageFactory()->createStringArrayListImmutable($rawSource);
        $this->prefix    = empty($prefix) ? static::DEFAULT_PREFIX : $prefix;
        $this->alt       = empty($alt) ? static::DEFAULT_ALT : $alt;

        parent::__construct($this->createSource());
    }

    /**
     * @return ImmutableInterface
     */
    public function getRawSource()
    {
        return $this->rawSource;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @return array
     */
    protected function createSource()
    {
        $source = [];

        foreach ($this->getRawSource()->getItems() as $index => $value) {
            $source[$this->prefix . $index] = $value;
        }

        return $source;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->getRawSource()->isEmpty() ? $this->alt : parent::toString();
    }
}