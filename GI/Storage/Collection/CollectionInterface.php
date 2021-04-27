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
namespace GI\Storage\Collection;

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\SessionExchange\BaseInterface\CacheClassInterface;

interface CollectionInterface extends ExtractionInterface, CacheClassInterface
{
    const DEFAULT_PAIR_GLUE = '=';


    /**
     * @param \Closure $pairGlue
     * @return string
     */
    public function getPairsWithClosure(\Closure $pairGlue);

    /**
     * @param string $pairGlue
     * @return string
     */
    public function getPairs(string $pairGlue = self::DEFAULT_PAIR_GLUE);

    /**
     * @param string $itemGlue
     * @param \Closure $pairGlue
     * @return string
     */
    public function joinPairsWithClosure(string $itemGlue, \Closure $pairGlue);

    /**
     * @param string $itemGlue
     * @param string $pairGlue
     * @return string
     */
    public function joinPairs(string $itemGlue, string $pairGlue = self::DEFAULT_PAIR_GLUE);
}