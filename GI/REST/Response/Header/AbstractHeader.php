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
namespace GI\REST\Response\Header;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

abstract class AbstractHeader implements HeaderInterface
{
    use ServiceLocatorAwareTrait;


    const HEADER_PATTERN = '%s: %s';


    /**
     * @var string
     */
    private $key = '';

    /**
     * @var string
     */
    private $content = '';


    /**
     * Header constructor.
     * @param string $key
     * @param string $content
     */
    public function __construct(string $key, string $content)
    {
        $this->key     = $key;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCollectionKey()
    {
        return empty($this->key) ? static::class : $this->key;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return empty($this->key) ? $this->content : sprintf(self::HEADER_PATTERN, $this->key, $this->content);
    }

    /**
     * @return static
     */
    public function send()
    {
        header($this->toString());

        return $this;
    }
}