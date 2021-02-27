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
namespace GI\I18n\Translator;

use GI\I18n\Translator\Glossary\GlossaryInterface;

interface TranslatorInterface 
{
    const DEFAULT_SOURCE_LOCALE = 'en_GB';


    /**
     * @return GlossaryInterface
     */
    public function getGlossary();

    /**
     * @param GlossaryInterface $glossary
     * @return static
     */
    public function setGlossary(GlossaryInterface $glossary);

    /**
     * @return string
     */
    public function getSourceLocale();

    /**
     * @param string $sourceLocale
     * @return static
     */
    public function setSourceLocale(string $sourceLocale);

    /**
     * @return static
     */
    public function setSourceLocaleToDefault();

    /**
     * @return string
     */
    public function getTargetLocale();

    /**
     * @param string $targetLocale
     * @return static
     */
    public function setTargetLocale(string $targetLocale);

    /**
     * @return static
     */
    public function setTargetLocaleToDefault();

    /**
     * @return bool
     */
    public function isWithMainLocales();

    /**
     * @param bool $withMainLocales
     * @return static
     */
    public function setWithMainLocales(bool $withMainLocales);

    /**
     * @return bool
     */
    public function isFound();

    /**
     * @param string $text
     * @return string
     */
    public function translate(string $text);
}