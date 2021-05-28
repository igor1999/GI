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
namespace GI\FileSystem\CSV\Context;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Validation\ValidationTrait;

abstract class AbstractContext implements ContextInterface
{
    use ServiceLocatorAwareTrait, ValidationTrait;


    /**
     * @var string
     */
    private $delimiter = self::DEFAULT_DELIMITER;

    /**
     * @var string
     */
    private $enclosure = self::DEFAULT_ENCLOSURE;

    /**
     * @var string
     */
    private $escape = self::DEFAULT_ESCAPE;


    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     * @return static
     */
    public function setDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @param string $enclosure
     * @return static
     */
    public function setEnclosure(string $enclosure)
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    /**
     * @return string
     */
    public function getEscape()
    {
        return $this->escape;
    }

    /**
     * @param string $escape
     * @return static
     */
    public function setEscape(string $escape)
    {
        $this->escape = $escape;

        return $this;
    }

    /**
     * @validate
     * @return static
     * @throws \Exception
     */
    protected function validateDelimiter()
    {
        if (strlen($this->delimiter) != 1 ) {
            $this->getGiServiceLocator()->throwInvalidValueException('Delimiter length', $this->delimiter, 1);
        }

        return $this;
    }

    /**
     * @validate
     * @return static
     * @throws \Exception
     */
    protected function validateEnclosure()
    {
        if (strlen($this->enclosure) != 1 ) {
            $this->getGiServiceLocator()->throwInvalidValueException('Enclosure length', $this->enclosure, 1);
        }

        return $this;
    }

    /**
     * @validate
     * @return static
     * @throws \Exception
     */
    protected function validateEscape()
    {
        if (strlen($this->escape) != 1 ) {
            $this->getGiServiceLocator()->throwInvalidValueException('Escape length', $this->escape, 1);
        }

        return $this;
    }
}