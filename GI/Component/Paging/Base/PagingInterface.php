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
namespace GI\Component\Paging\Base;

use GI\Component\Base\ComponentInterface;
use GI\ClientContents\Paging\Base\PagingInterface as PagingModelInterface;

interface PagingInterface extends ComponentInterface
{
    /**
     * @return PagingModelInterface
     */
    public function getPagingModel();

    /**
     * @param array $contents
     * @param int $entriesTotal
     * @return static
     */
    public function hydrate(array $contents, int $entriesTotal = 0);

    /**
     * @return string
     * @throws \Exception
     */
    public function toString();
}