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
namespace GI\REST\Request\Upload;

use GI\Pattern\ArrayExchange\ArrayExchangeInterface;

interface UploadInterface extends ArrayExchangeInterface
{
    /**
     * @param array $types
     * @return boolean
     */
    public function validateMimeType(array $types);

    /**
     * @param int|null $min
     * @param int|null $max
     * @return boolean
     */
    public function validateSize(int $min = null, int $max = null);

    /**
     * @return boolean
     */
    public function validateError();

    /**
     * @return bool
     */
    public function remove();
}