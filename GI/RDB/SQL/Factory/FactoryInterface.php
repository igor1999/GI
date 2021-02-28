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
namespace GI\RDB\SQL\Factory;

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\RDB\Meta\Table\TableInterface;

use GI\RDB\SQL\Expression\Field\FieldInterface as FieldExpressionInterface;
use GI\RDB\SQL\Expression\Field\ParserInterface as FieldParserInterface;
use GI\RDB\SQL\Expression\Param\ParamInterface as ParamExpressionInterface;
use GI\RDB\SQL\Expression\Placeholder\PlaceholderInterface as PlaceholderExpressionInterface;

use GI\RDB\SQL\Cortege\Assign\AssignInterface as AssignCortegeInterface;
use GI\RDB\SQL\Cortege\Field\FieldInterface as FieldCortegeInterface;
use GI\RDB\SQL\Cortege\Param\ParamInterface as ParamCortegeInterface;
use GI\RDB\SQL\Cortege\Param\InInterface as InCortegeInterface;

use GI\RDB\SQL\Cortege\Predicates\AndAssign\AndAssignInterface as AndAssignPredicatesInterface;
use GI\RDB\SQL\Cortege\Predicates\OrAssign\OrAssignInterface as OrAssignPredicatesInterface;
use GI\RDB\SQL\Cortege\Predicates\Join\JoinInterface as JoinPredicatesInterface;

use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;

/**
 * Interface FactoryInterface
 * @package GI\RDB\SQL\Factory
 *
 * @method FieldExpressionInterface createFieldExpression(string $name)
 * @method FieldParserInterface createFieldParser()
 * @method ParamExpressionInterface createParamExpression(string $name)
 * @method PlaceholderExpressionInterface createPlaceholderExpression(string $name)
 * @method AssignCortegeInterface createAssignCortege(array $items, TableInterface $table = null)
 * @method FieldCortegeInterface createFieldCortege(array $items, TableInterface $table = null)
 * @method ParamCortegeInterface createParamCortege(array $items)
 * @method InCortegeInterface createInCortege(array $rawSource, string $prefix = null, string $alt = null)
 * @method AndAssignPredicatesInterface createAndAssignPredicates(array $items, TableInterface $table = null)
 * @method OrAssignPredicatesInterface createOrAssignPredicates(array $items, TableInterface $table = null)
 * @method JoinPredicatesInterface createJoinPredicates(array $items, TableInterface $table = null, TableInterface $joinTable = null)
 * @method SQLBuilderInterface createSQLBuilder()
 */
interface FactoryInterface extends BaseInterface
{

}