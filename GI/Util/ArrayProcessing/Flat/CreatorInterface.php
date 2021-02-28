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
namespace GI\Util\ArrayProcessing\Flat;

interface CreatorInterface
{
    /**
     * @param array $contents
     * @param \Closure|null $localKeyMaker
     * @return array
     */
    public function create(array $contents, \Closure $localKeyMaker = null);

    /**
     * @param array $contents
     * @param string $separator
     * @return array
     */
    public function createWithKeySeparator(array $contents, string $separator);

    /**
     * @param array $contents
     * @return array
     */
    public function createWithKeySeparatorPoint(array $contents);

    /**
     * @param array $contents
     * @return array
     */
    public function createWithKeySeparatorSlash(array $contents);

    /**
     * @param array $contents
     * @return array
     */
    public function createWithKeySeparatorHyphen(array $contents);

    /**
     * @param array $contents
     * @return array
     */
    public function createWithArrayLikeKeys(array $contents);
}