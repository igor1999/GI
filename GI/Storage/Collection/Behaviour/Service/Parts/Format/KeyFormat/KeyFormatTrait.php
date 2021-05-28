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
namespace GI\Storage\Collection\Behaviour\Service\Parts\Format\KeyFormat;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Storage\Collection\Behaviour\Option\Parts\Format\KeyFormat\KeyFormatInterface as OptionInterface;

trait KeyFormatTrait
{
    /**
     * @return string
     */
    public function getKeyFormat()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getKeyFormat();
    }

    /**
     * @param string $key
     * @return string
     * @throws \Exception
     */
    public function formatKey(string $key)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        if ($this->getKeyFormat() == OptionInterface::KEY_FORMAT_CAMEL_CASE_UCFIRST) {
            $key = ucfirst($key);
        } elseif ($this->getKeyFormat() == OptionInterface::KEY_FORMAT_HYPHEN_UPPER_CASE) {
            $key = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToHyphenUpperCase($key);
        } elseif ($this->getKeyFormat() == OptionInterface::KEY_FORMAT_HYPHEN_LOWER_CASE) {
            $key = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToHyphenLowerCase($key);
        } elseif ($this->getKeyFormat() == OptionInterface::KEY_FORMAT_HYPHEN_UCFIRST) {
            $key = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToHyphenUpperFirst($key);
        } elseif ($this->getKeyFormat() == OptionInterface::KEY_FORMAT_UNDERLINE_UPPER_CASE) {
            $key = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToUnderlineUpperCase($key);
        } elseif ($this->getKeyFormat() == OptionInterface::KEY_FORMAT_UNDERLINE_LOWER_CASE) {
            $key = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToUnderlineLowerCase($key);
        } elseif ($this->getKeyFormat() == OptionInterface::KEY_FORMAT_UNDERLINE_UCFIRST) {
            $key = $me->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToUnderlineUpperFirst($key);
        }

        return $key;
    }
}