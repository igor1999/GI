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

use GI\Pattern\Factory\AbstractFactory;

use GI\RDB\SQL\Expression\Field\Field as FieldExpression;
use GI\RDB\SQL\Expression\Field\Parser as FieldParser;
use GI\RDB\SQL\Expression\Param\Param as ParamExpression;
use GI\RDB\SQL\Expression\Placeholder\Placeholder as PlaceholderExpression;

use GI\RDB\SQL\Cortege\Assign\Assign as AssignCortege;
use GI\RDB\SQL\Cortege\Field\Field as FieldCortege;
use GI\RDB\SQL\Cortege\Param\In as InCortege;
use GI\RDB\SQL\Cortege\Param\Param as ParamCortege;

use GI\RDB\SQL\Cortege\Predicates\AndAssign\AndAssign as AndAssignPredicates;
use GI\RDB\SQL\Cortege\Predicates\OrAssign\OrAssign as OrAssignPredicates;
use GI\RDB\SQL\Cortege\Predicates\Join\Join as JoinPredicates;

use GI\RDB\SQL\Builder\Builder as SQLBuilder;


use GI\RDB\Meta\Table\TableInterface;
use GI\RDB\SQL\Expression\ExpressionInterface;
use GI\RDB\SQL\Cortege\CortegeInterface;

use GI\RDB\SQL\Expression\Field\FieldInterface as FieldExpressionInterface;
use GI\RDB\SQL\Expression\Field\ParserInterface as FieldParserInterface;
use GI\RDB\SQL\Expression\Param\ParamInterface as ParamExpressionInterface;
use GI\RDB\SQL\Expression\Placeholder\PlaceholderInterface as PlaceholderExpressionInterface;

use GI\RDB\SQL\Cortege\Assign\AssignInterface as AssignCortegeInterface;
use GI\RDB\SQL\Cortege\Field\FieldInterface as FieldCortegeInterface;
use GI\RDB\SQL\Cortege\Param\InInterface as InCortegeInterface;
use GI\RDB\SQL\Cortege\Param\ParamInterface as ParamCortegeInterface;

use GI\RDB\SQL\Cortege\Predicates\AndAssign\AndAssignInterface as AndAssignPredicatesInterface;
use GI\RDB\SQL\Cortege\Predicates\OrAssign\OrAssignInterface as OrAssignPredicatesInterface;
use GI\RDB\SQL\Cortege\Predicates\Join\JoinInterface as JoinPredicatesInterface;

use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;

/**
 * Class Factory
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
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()
            ->add(CortegeInterface::class)
            ->add(SQLBuilderInterface::class)
            ->add(ExpressionInterface::class);

        $this->setNamed('FieldExpression', FieldExpression::class)
            ->setNamed('FieldParser', FieldParser::class)
            ->setNamed('ParamExpression', ParamExpression::class)
            ->setNamed('PlaceholderExpression', PlaceholderExpression::class)

            ->setNamed('AssignCortege', AssignCortege::class)
            ->setNamed('FieldCortege', FieldCortege::class)
            ->setNamed('InCortege', InCortege::class)
            ->setNamed('ParamCortege', ParamCortege::class)

            ->setNamed('AndAssignPredicates', AndAssignPredicates::class)
            ->setNamed('OrAssignPredicates', OrAssignPredicates::class)
            ->setNamed('JoinPredicates', JoinPredicates::class)

            ->setNamed('SQLBuilder', SQLBuilder::class)
        ;
    }
}