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
namespace GI\FileSystem\CSV\Writer;

use GI\FileSystem\CSV\AbstractCSV;
use GI\FileSystem\CSV\Writer\Context\Context;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\CSV\Writer\Context\ContextInterface;

class Writer extends AbstractCSV implements WriterInterface
{
    /**
     * @var ContextInterface
     */
    private $context;


    /**
     * Writer constructor.
     * @param FSOFileInterface $file
     * @throws \Exception
     */
    public function __construct(FSOFileInterface $file)
    {
        $this->context = $this->getGiServiceLocator()->getDependency(ContextInterface::class,Context::class);
        $this->context->validateProperties();

        parent::__construct($file);
    }

    /**
     * @return ContextInterface
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param array $source
     * @return static
     * @throws \Exception
     */
    public function writeRows(array $source)
    {
        $handle = fopen($this->getFile()->getPath(), "x");

        if ($handle === false) {
            $this->throwCSVException();
        }

        foreach ($source as $row) {
            $this->put($handle, $row);
        }

        fclose($handle);

        return $this;
    }

    /**
     * @param array $source
     * @return static
     * @throws \Exception
     */
    public function writeColumns(array $source)
    {
        $handle = fopen($this->getFile()->getPath(), "x");

        if ($handle === false) {
            $this->throwCSVException();
        }

        $f = function(array $column)
        {
            return count($column);
        };
        $sizes = array_map($f, $source);
        sort($sizes);
        $max = array_pop($sizes);

        $this->put($handle, array_keys($source));

        $values = array_values($source);
        for($i = 0; $i <= $max - 1; $i ++) {
            $row = [];
            foreach ($values as $column) {
                $row[] = array_key_exists($i, $column) ? $column[$i] : '';
            }

            $this->put($handle, $row);
        }

        fclose($handle);

        return $this;
    }

    /**
     * @param resource $handle
     * @param array $row
     * @return static
     */
    protected function put($handle, array $row)
    {
        fputcsv(
            $handle,
            $row,
            $this->getContext()->getDelimiter(),
            $this->getContext()->getEnclosure(),
            $this->getContext()->getEscape()
        );

        return $this;
    }
}