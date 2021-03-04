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
namespace GI\ServiceLocator\AwareTraits;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\I18n\Locales\Sounding\SoundingInterface;
use GI\I18n\Translator\TranslatorInterface;

trait I18nAwareTrait
{
    /**
     * @return SoundingInterface
     */
    protected function giCreateSounding()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->createSounding(static::class);
    }

    /**
     * @param string $interface
     * @param mixed $default
     * @param string $text
     * @return string
     */
    protected function giTranslate(string $interface, $default, string $text)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->translate($interface, $default, $text);
    }

    /**
     * @param string $interface
     * @param mixed $default
     * @return TranslatorInterface
     * @throws \Exception
     */
    protected function giCreateDefaultTranslator(string $interface, $default)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->createDefaultTranslator($interface, $default);
    }
}