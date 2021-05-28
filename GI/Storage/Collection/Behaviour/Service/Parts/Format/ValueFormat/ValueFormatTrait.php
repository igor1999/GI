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
namespace GI\Storage\Collection\Behaviour\Service\Parts\Format\ValueFormat;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Storage\Collection\Behaviour\Option\Parts\Format\ValueFormat\ValueFormatInterface as OptionInterface;

trait ValueFormatTrait
{
    /**
     * @return string
     */
    public function getValueFormat()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getValueFormat();
    }

    /**
     * @param string $value
     * @return string
     * @throws \Exception
     */
    public function formatValue(string $value)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        if ($this->getValueFormat() == OptionInterface::VALUE_FORMAT_CAMEL_CASE_UCFIRST) {
            $value = ucfirst($value);
        } elseif ($this->getValueFormat() == OptionInterface::VALUE_FORMAT_HYPHEN_UPPER_CASE) {
            $value = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToHyphenUpperCase($value);
        } elseif ($this->getValueFormat() == OptionInterface::VALUE_FORMAT_HYPHEN_LOWER_CASE) {
            $value = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToHyphenLowerCase($value);
        } elseif ($this->getValueFormat() == OptionInterface::VALUE_FORMAT_HYPHEN_UCFIRST) {
            $value = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToHyphenUpperFirst($value);
        } elseif ($this->getValueFormat() == OptionInterface::VALUE_FORMAT_UNDERLINE_UPPER_CASE) {
            $value = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToUnderlineUpperCase($value);
        } elseif ($this->getValueFormat() == OptionInterface::VALUE_FORMAT_UNDERLINE_LOWER_CASE) {
            $value = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToUnderlineLowerCase($value);
        } elseif ($this->getValueFormat() == OptionInterface::VALUE_FORMAT_UNDERLINE_UCFIRST) {
            $value = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToUnderlineUpperFirst($value);
        }

        return $value;
    }
}