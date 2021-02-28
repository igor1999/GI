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
namespace GI\I18n\Translator\Glossary;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\I18n\Translator\Reader\ReaderInterface;

interface GlossaryInterface 
{
    /**
     * @param FSOFileInterface $source
     * @return bool
     */
    public function has(FSOFileInterface $source);

    /**
     * @param FSOFileInterface $source
     * @return ReaderInterface
     * @throws \Exception
     */
    public function get(FSOFileInterface $source);

    /**
     * @return ReaderInterface[]
     */
    public function getReaders();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param FSOFileInterface $source
     * @return bool
     * @throws \Exception
     */
    public function add(FSOFileInterface $source);

    /**
     * @param FSOFileInterface $source
     * @return bool
     */
    public function remove(FSOFileInterface $source);

    /**
     * @return static
     */
    public function clean();

    /**
     * @param string $sourceLocale
     * @param string $targetLocale
     * @param string $text
     * @param bool $withMainLocales
     * @return bool|string
     * @throws \Exception
     */
    public function translate(string $sourceLocale, string $targetLocale, string $text, bool $withMainLocales = true);
}