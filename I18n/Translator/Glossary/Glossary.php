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

use GI\I18n\Translator\Reader\Reader;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\I18n\Translator\Reader\ReaderInterface;

class Glossary implements GlossaryInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_RELATIVE_PATH = 'source/glossary.csv';


    /**
     * @var ReaderInterface[]
     */
    private $readers = [];


    /**
     * @param FSOFileInterface $source
     * @return bool
     */
    public function has(FSOFileInterface $source)
    {
        return isset($this->readers[$source->getPath()]);
    }

    /**
     * @param FSOFileInterface $source
     * @return ReaderInterface
     * @throws \Exception
     */
    public function get(FSOFileInterface $source)
    {
        if (!$this->has($source)) {
            $this->giThrowNotInScopeException($source->getPath());
        }

        return $this->readers[$source->getPath()];
    }

    /**
     * @return ReaderInterface[]
     */
    public function getReaders()
    {
        return $this->readers;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->readers);
    }

    /**
     * @param FSOFileInterface $source
     * @return bool
     * @throws \Exception
     */
    public function add(FSOFileInterface $source)
    {
        if ($result = !$this->has($source)) {
            $this->readers[$source->getPath()] = $this->createReader($source);
        }

        return $result;
    }

    /**
     * @param FSOFileInterface $source
     * @return Reader
     * @throws \Exception
     */
    protected function createReader(FSOFileInterface $source)
    {
        try {
            $reader = $this->giGetDi(ReaderInterface::class,null, [$source]);
        } catch (\Exception $e) {
            $reader = new Reader($source);
        }

        return $reader;
    }

    /**
     * @param string $class
     * @param string|null $relativePath
     * @return static
     * @throws \Exception
     */
    protected function addByClass(string $class, string $relativePath = null)
    {
        if (empty($relativePath)) {
            $relativePath = static::DEFAULT_RELATIVE_PATH;
        }

        $this->add($this->giCreateClassDirChildFile($class, $relativePath));

        return $this;
    }

    /**
     * @param FSOFileInterface $source
     * @return bool
     */
    public function remove(FSOFileInterface $source)
    {
        if ($result = $this->has($source)) {
            unset($this->readers[$source->getPath()]);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->readers = [];

        return $this;
    }

    /**
     * @param string $sourceLocale
     * @param string $targetLocale
     * @param string $text
     * @param bool $withMainLocales
     * @return bool|string
     * @throws \Exception
     */
    public function translate(string $sourceLocale, string $targetLocale, string $text, bool $withMainLocales = true)
    {
        $result = false;

        foreach ($this->getReaders() as $reader) {
            $result = $reader->translate($sourceLocale, $targetLocale, $text, $withMainLocales);

            if ($result !== false) {
                break;
            }
        }

        return $result;
    }
}