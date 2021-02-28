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
namespace GI\Email\Body;

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

interface BodyInterface extends ExtractionInterface
{
    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return PartInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return PartInterface[]
     */
    public function getParts();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param PartInterface $part
     * @return static
     */
    public function prepend(PartInterface $part);

    /**
     * @param PartInterface $part
     * @return static
     */
    public function append(PartInterface $part);

    /**
     * @param int $index
     * @param PartInterface $part
     * @return static
     */
    public function insert(int $index, PartInterface $part);

    /**
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     * @return static
     */
    public function prependAttachment(FSOFileInterface $file, bool $base64Encoding = false);

    /**
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     * @return static
     */
    public function appendAttachment(FSOFileInterface $file, bool $base64Encoding = false);

    /**
     * @param int $index
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     * @return static
     */
    public function insertAttachment(int $index, FSOFileInterface $file, bool $base64Encoding = false);

    /**
     * @param string $text
     * @return static
     */
    public function prependText(string $text);

    /**
     * @param string $text
     * @return static
     */
    public function appendText(string $text);

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertText(int $index, string $text);

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index);

    /**
     * @return static
     */
    public function clean();
}