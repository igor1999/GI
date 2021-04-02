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
namespace GI\RDB\SQL\Builder;

use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\RDB\SQL\Builder\Params\ParamsInterface;
use GI\RDB\SQL\Builder\Condition\ConditionListInterface;
use GI\RDB\SQL\Cortege\CortegeInterface;
use GI\RDB\SQL\Cortege\Predicates\PredicatesInterface as PredicateCortegeInterface;
use GI\RDB\SQL\Builder\Part\PartListInterface;

interface BuilderInterface extends  StringConvertableInterface
{
    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param string $template
     * @return static
     */
    public function setTemplate(string $template);

    /**
     * @return ParamsInterface
     */
    public function getParams();

    /**
     * @return ConditionListInterface
     */
    public function getPredicateList();

    /**
     * @return PartListInterface
     */
    public function getPartList();

    /**
     * @param string $param
     * @param mixed $value
     * @return static
     */
    public function setParam(string $param, $value);

    /**
     * @param string $param
     * @param CortegeInterface $cortege
     * @return static
     */
    public function setCortegeAsParam(string $param, CortegeInterface $cortege);

    /**
     * @param array $params
     * @return static
     */
    public function setPredicateParams(array $params);

    /**
     * @param bool $alt
     * @return static
     */
    public function setPredicateAlt(bool $alt);

    /**
     * @param string $placeholder
     * @param string $predicate
     * @param \Closure|null $validator
     * @param bool|null $alt
     * @return static
     */
    public function setPredicate(string $placeholder, string $predicate, \Closure $validator = null, bool $alt = null);

    /**
     * @param string $placeholder
     * @param PredicateCortegeInterface $cortege
     * @param bool|null $alt
     * @return static
     * @throws \Exception
     */
    public function setCortegeByContents(string $placeholder, PredicateCortegeInterface $cortege, bool $alt = null);

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addOrder(array $value, string $placeholder = '');

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addGroup(array $value, string $placeholder = '');

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     */
    public function addLimit($value, string $placeholder = '');

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     */
    public function addOffset($value, string $placeholder = '');
}