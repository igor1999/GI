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
namespace GI\Storage\Collection\Behaviour\Service\Parts\Bounds\StringLength;

use GI\Storage\Collection\Behaviour\Option\Parts\Bounds\StringLength\StringLengthInterface as OptionInterface;

trait StringLengthTrait
{
    /**
     * @return int
     */
    public function getMinLength()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getMinLength();
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getMaxLength();
    }

    /**
     * @param string $item
     * @return static
     * @throws \Exception
     */
    public function validateMinLength(string $item)
    {
        $length = $this->getMinLength();

        if (($length > 0) && (strlen($item) < $length)) {
            $this->getGiServiceLocator()->throwInvalidMinimumException('Length of', $item, $length);
        }

        return $this;
    }

    /**
     * @param string $item
     * @return static
     * @throws \Exception
     */
    public function validateMaxLength(string $item)
    {
        $length = $this->getMaxLength();

        if (($length > 0) && (strlen($item) > $length)) {
            $this->getGiServiceLocator()->throwInvalidMaximumException('Length of', $item, $length);
        }

        return $this;
    }

    /**
     * @param string $item
     * @return static
     * @throws \Exception
     */
    public function validateLength(string $item)
    {
        $this->validateMinLength($item)->validateMaxLength($item);

        return $this;
    }
}