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
namespace GI\Filter\Simple\DateTime;

use GI\Filter\AbstractFilter;

use GI\Validator\Simple\DateTime\DateInterface as BaseValidatorInterface;

abstract class AbstractDateTime extends AbstractFilter implements DateTimeInterface
{
    /**
     * @var mixed
     */
    private $defaultValue;


    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     * @return static
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * @return static
     */
    public function setDefaultValueToEmpty()
    {
        $this->setDefaultValue('');

        return $this;
    }

    /**
     * @return static
     */
    public function setDefaultValueToNow()
    {
        $this->setDefaultValue($this->getNow());

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getNow();

    /**
     * @return string
     */
    public function execute()
    {
        return $this->createValidator()->validate($this->getInput()) ? $this->getInput() : $this->getDefaultValue();
    }

    /**
     * @return BaseValidatorInterface
     */
    abstract protected function createValidator();
}