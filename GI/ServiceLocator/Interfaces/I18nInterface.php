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
namespace GI\ServiceLocator\Interfaces;

use GI\I18n\Translator\TranslatorInterface;
use GI\I18n\Locales\Sounding\SoundingInterface;

interface I18nInterface
{
    const DEFAULT_USER_LOCALE = 'en_GB';


    /**
     * @param string|null $caller
     * @return SoundingInterface
     */
    public function createSounding(string $caller = null);

    /**
     * @param string $interface
     * @param string|mixed $default
     * @param string $text
     * @return string
     */
    public function translate(string $interface, $default, string $text);

    /**
     * @param string $interface
     * @param string|mixed $default
     * @return TranslatorInterface
     * @throws \Exception
     */
    public function createDefaultTranslator(string $interface, $default);

    /**
     * @return string
     */
    public function getUserLocale();

    /**
     * @param string $userLocale
     * @return static
     * @throws \Exception
     */
    public function setUserLocale(string $userLocale);
}