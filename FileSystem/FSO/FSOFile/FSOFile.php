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
namespace GI\FileSystem\FSO\FSOFile;

use GI\FileSystem\FSO\AbstractFSO;

use GI\FileSystem\FSO\Exception\Upload\ExceptionAwareTrait;

use GI\FileSystem\CSV\Reader\ReaderInterface as CSVReaderInterface;
use GI\FileSystem\CSV\Writer\WriterInterface as CSVWriterInterface;
use GI\FileSystem\Stream\Reader\ReaderInterface as StreamReaderInterface;
use GI\FileSystem\Stream\Writer\WriterInterface as StreamWriterInterface;

class FSOFile extends AbstractFSO implements FSOFileInterface
{
    use ExceptionAwareTrait;


    /**
     * @return CSVReaderInterface
     */
    public function createCSVReader()
    {
        return $this->getFactory()->createCSVReader($this);
    }

    /**
     * @return CSVWriterInterface
     */
    public function createCSVWriter()
    {
        return $this->getFactory()->createCSVWriter($this);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function create()
    {
        if (!$this->exists()) {
            $parent = $this->createParent();
            if (!$parent->exists()) {
                $parent->setMode($this->getMode())->create();
            }

            $handle = fopen($this->getPath(), 'x');
            fclose($handle);
        }

        return $this;
    }

    /**
     * @return static
     */
    public function delete()
    {
        if ($this->exists()) {
            unlink($this->getPath());
        }

        return $this;
    }

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function makeCopy(FSOFileInterface $file)
    {
        $this->fireInexistence();

        copy($this->getPath(), $file->getPath());

        return $this;
    }

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function move(FSOFileInterface $file)
    {
        $this->fireInexistence();

        rename($this->getPath(), $file->getPath());

        return $this;
    }

    /**
     * @return bool
     */
    public function isUploaded()
    {
        return is_uploaded_file($this->getPath());
    }

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function upload(FSOFileInterface $file)
    {
        if (!$this->isUploaded()) {
            $this->throwFSOUploadedException();
        }

        move_uploaded_file($this->getPath(), $file->getPath());

        return $this;
    }

    /**
     * @return bool
     */
    public function isFile()
    {
        return is_file($this->getPath());
    }

    /**
     * @return false|string
     * @throws \Exception
     */
    public function getContents()
    {
        $this->fireInexistence();

        return file_get_contents($this->getPath());
    }

    /**
     * @param string|array|resource $data
     * @return static
     */
    public function putContents($data)
    {
        file_put_contents($this->getPath(), $data);

        return $this;
    }

    /**
     * @param string|array|resource $data
     * @return static
     * @throws \Exception
     */
    public function appendContents($data)
    {
        $this->fireInexistence();

        file_put_contents($this->getPath(), $data, FILE_APPEND);

        return $this;
    }

    /**
     * @return array|bool
     * @throws \Exception
     */
    public function getLines()
    {
        $this->fireInexistence();

        return file($this->getPath());
    }

    /**
     * @return StreamReaderInterface
     * @throws \Exception
     */
    public function getReadStream()
    {
        $this->fireInexistence();

        $handle = fopen($this->getPath(), 'r');

        return $this->getFactory()->createStreamReader($handle);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function readAndClose()
    {
        return $this->getReadStream()->readAndClose($this->getMeta()->getSize());
    }

    /**
     * @return StreamWriterInterface
     */
    public function getWriteStream()
    {
        $handle = fopen($this->getPath(), 'w');

        return $this->getFactory()->createStreamWriter($handle);
    }

    /**
     * @return StreamWriterInterface
     * @throws \Exception
     */
    public function getAppendStream()
    {
        $this->fireInexistence();

        $handle = fopen($this->getPath(), 'a');

        return $this->getFactory()->createStreamWriter($handle);
    }
}