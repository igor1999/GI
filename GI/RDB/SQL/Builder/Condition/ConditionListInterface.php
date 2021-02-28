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
namespace GI\RDB\SQL\Builder\Condition;

use GI\RDB\SQL\Builder\BuilderInterface;
use GI\RDB\SQL\Cortege\Predicates\PredicatesInterface;
use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\AlterableInterface;

interface ConditionListInterface
{
    /**
     * @return BuilderInterface
     */
    public function getBuilder();

    /**
     * @return AlterableInterface
     */
    public function getParams();

    /**
     * @param array $params
     * @return static
     */
    public function setParams(array $params);

    /**
     * @return bool
     */
    public function isAlt();

    /**
     * @param bool $alt
     * @return static
     */
    public function setAlt(bool $alt);

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return ConditionInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return ConditionInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return int
     */
    public function isEmpty();

    /**
     * @param string $placeholder
     * @param ConditionInterface $predicate
     * @return static
     */
    public function set(string $placeholder, ConditionInterface $predicate);

    /**
     * @param string $placeholder
     * @param string $predicate
     * @param \Closure|null $validator
     * @param bool|null $alt
     * @return static
     */
    public function setByContents(string $placeholder, string $predicate, \Closure $validator = null, bool $alt = null);

    /**
     * @param string $placeholder
     * @param PredicatesInterface $predicates
     * @param bool|null $alt
     * @return static
     * @throws \Exception
     */
    public function setCortegeConditionByContents(string $placeholder, PredicatesInterface $predicates, bool $alt = null);

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key);

    /**
     * @return static
     */
    public function clean();

    /**
     * @return static
     */
    public function build();
}