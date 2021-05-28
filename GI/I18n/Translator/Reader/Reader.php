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
namespace GI\I18n\Translator\Reader;

use GI\I18n\Locales\Main\Main as MainLocales;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\I18n\Locales\Main\MainInterface as MainLocalesInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

class Reader implements ReaderInterface
{
    use ServiceLocatorAwareTrait;


    const DELIMITER = '|';


    /**
     * @var FSOFileInterface
     */
    private $source;

    /**
     * @var array
     */
    private $contents = [];

    /**
     * @var MainLocalesInterface
     */
    private $mainLocales;


    /**
     * Reader constructor.
     * @param FSOFileInterface $source
     * @throws \Exception
     */
    public function __construct(FSOFileInterface $source)
    {
        $this->source = $source;

        $this->mainLocales = $this->getGiServiceLocator()->getDependency(MainLocalesInterface::class,MainLocales::class);

        $this->createContents();
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createContents()
    {
        $reader = $this->getSource()->createCSVReader();
        $reader->getContext()->setDelimiter(static::DELIMITER);

        $this->contents = $reader->readColumns();

        return $this;
    }

    /**
     * @return FSOFileInterface
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return array
     */
    protected function getContents()
    {
        return $this->contents;
    }

    /**
     * @return MainLocalesInterface
     */
    protected function getMainLocales()
    {
        return $this->mainLocales;
    }

    /**
     * @param string $sourceLocale
     * @param string $targetLocale
     * @param string $text
     * @param bool $withMainLocales
     * @return string|false
     * @throws \Exception
     */
    public function translate(string $sourceLocale, string $targetLocale, string $text, bool $withMainLocales = true)
    {
        $result = $this->search($sourceLocale, $targetLocale, $text);

        if ($withMainLocales) {
            $mainSourceLocale = $mainTargetLocale = '';

            if (($result === false) && $this->getMainLocales()->has($sourceLocale)) {
                $mainSourceLocale = $this->getMainLocales()->get($sourceLocale);
                $result = $this->search($mainSourceLocale, $targetLocale, $text);
            }

            if (($result === false) && $this->getMainLocales()->has($targetLocale)) {
                $mainTargetLocale = $this->getMainLocales()->get($targetLocale);
                $result = $this->search($sourceLocale, $mainTargetLocale, $text);
            }

            if (($result === false) && !empty($mainSourceLocale) && !empty($mainTargetLocale)) {
                $result = $this->search($mainSourceLocale, $mainTargetLocale, $text);
            }
        }

        return $result;
    }

    /**
     * @param string $sourceLocale
     * @param string $targetLocale
     * @param string $text
     * @return string|false
     */
    protected function search(string $sourceLocale, string $targetLocale, string $text)
    {
        $result = false;

        if (isset($this->contents[$sourceLocale]) && isset($this->contents[$targetLocale])) {
            $index = array_search($text, $this->contents[$sourceLocale]);
            if (($index !== false) && !empty($this->contents[$targetLocale][$index])) {
                $result = $this->contents[$targetLocale][$index];
            }
        }

        return $result;
    }
}