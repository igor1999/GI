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

use GI\FileSystem\Stream\Reader\ReaderInterface as StreamReaderInterface;
use GI\FileSystem\Stream\Writer\WriterInterface as StreamWriterInterface;
use GI\FileSystem\CSV\Reader\ReaderInterface as CSVReaderInterface;
use GI\FileSystem\CSV\Writer\WriterInterface as CSVWriterInterface;
use GI\FileSystem\FSO\FSOInterface;

interface FSOFileInterface extends FSOInterface
{
    /**
     * @return CSVReaderInterface
     */
    public function createCSVReader();

    /**
     * @return CSVWriterInterface
     */
    public function createCSVWriter();

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function makeCopy(FSOFileInterface $file);

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function move(FSOFileInterface $file);

    /**
     * @return bool
     */
    public function isUploaded();

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function upload(FSOFileInterface $file);

    /**
     * @return bool
     */
    public function isFile();

    /**
     * @return false|string
     * @throws \Exception
     */
    public function getContents();

    /**
     * @param string|array|resource $data
     * @return static
     */
    public function putContents($data);

    /**
     * @param string|array|resource $data
     * @return static
     * @throws \Exception
     */
    public function appendContents($data);

    /**
     * @return array|bool
     * @throws \Exception
     */
    public function getLines();

    /**
     * @return StreamReaderInterface
     * @throws \Exception
     */
    public function getReadStream();

    /**
     * @return string
     * @throws \Exception
     */
    public function readAndClose();

    /**
     * @return StreamWriterInterface
     * @throws \Exception
     */
    public function getWriteStream();

    /**
     * @return StreamWriterInterface
     * @throws \Exception
     */
    public function getAppendStream();
}