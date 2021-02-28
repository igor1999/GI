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
namespace GI\REST\Request\Upload\Collection;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\Pattern\Closing\ClosingInterface;
use GI\REST\Request\Upload\UploadInterface;

interface CollectionInterface extends  UploadInterface, ClosingInterface
{
    /**
     * @param string|int $key
     * @return bool
     */
    public function has($key);

    /**
     * @param string|int $key
     * @return UploadInterface
     * @throws \Exception
     */
    public function get($key);

    /**
     * @return UploadInterface[]
     */
    public function getItems();

    /**
     * @return UploadInterface[]
     */
    public function getItemsRecursive();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param string|int $key
     * @param UploadInterface $item
     * @return static
     * @throws \Exception
     */
    public function set($key, UploadInterface $item);

    /**
     * @param string|int $key
     * @return static
     * @throws \Exception
     */
    public function removeItem($key);

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();

    /**
     * @param FSODirInterface $targetDir
     * @return static
     * @throws \Exception
     * @throws \Exception
     */
    public function upload(FSODirInterface $targetDir);

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents);
}