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
namespace GI\FileSystem\CSV\Reader;

use GI\FileSystem\CSV\AbstractCSV;
use GI\FileSystem\CSV\Reader\Context\Context;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\CSV\Reader\Context\ContextInterface;

class Reader extends AbstractCSV implements ReaderInterface
{
    /**
     * @var ContextInterface
     */
    private $context;


    /**
     * Reader constructor.
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
     * @return array
     * @throws \Exception
     */
    public function readRows()
    {
        $this->getFile()->fireInexistence();

        $handle = fopen($this->getFile()->getPath(), "r");

        if ($handle === false) {
            $this->throwCSVException();
        }

        $result = [];
        while (true) {
            $data = $this->get($handle);

            if (!is_array($data)) {
                break;
            }

            $result[] = $data;
        }

        fclose($handle);

        return $result;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function readColumns()
    {
        $this->getFile()->fireInexistence();

        $handle = fopen($this->getFile()->getPath(), "r");

        if ($handle === false) {
            $this->throwCSVException();
        }

        $keys = $values = [];
        $index = 0;
        while (true) {
            $data = $this->get($handle);

            if (!is_array($data)) {
                break;
            }

            if ($index == 0) {
                $keys   = $data;
                $values = array_fill(0, count($keys), []);
            } else {
                foreach ($data as $index => $value) {
                    if (array_key_exists($index, $keys)) {
                        $values[$index][] = $value;
                    }
                }
            }

            $index += 1;
        }

        fclose($handle);

        return array_combine($keys, $values);
    }

    /**
     * @param resource $handle
     * @return array|false|null
     */
    protected function get($handle)
    {
        return fgetcsv(
            $handle,
            $this->getContext()->getLength(),
            $this->getContext()->getDelimiter(),
            $this->getContext()->getEnclosure(),
            $this->getContext()->getEscape()
        );
    }
}