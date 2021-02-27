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
namespace GI\RDB\SQL\Builder\Condition\Cortege;

use GI\RDB\SQL\Builder\Condition\Condition;

use GI\RDB\SQL\Builder\Condition\ConditionListInterface;
use GI\RDB\SQL\Cortege\Predicates\PredicatesInterface;

class Cortege extends Condition implements CortegeInterface
{
    /**
     * Cortege constructor.
     * @param ConditionListInterface $predicateList
     * @param string $placeholder
     * @param PredicatesInterface $cortege
     * @param bool|null $alt
     * @throws \Exception
     */
    public function __construct(
        ConditionListInterface $predicateList, string $placeholder, PredicatesInterface $cortege, bool $alt = null)
    {
        $predicate = $cortege->toString();

        $validator = function() use ($predicate)
        {
            return !empty($predicate);
        };

        parent::__construct($predicateList, $placeholder, $predicate, $validator, $alt);
    }
}