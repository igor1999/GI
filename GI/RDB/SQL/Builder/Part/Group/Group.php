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
namespace GI\RDB\SQL\Builder\Part\Group;

use GI\RDB\SQL\Builder\Part\AbstractPart;

use GI\RDB\SQL\Builder\BuilderInterface;

class Group extends AbstractPart implements GroupInterface
{
    const DEFAULT_PLACEHOLDER = 'group';


    const GLUE = ', ';


    /**
     * Group constructor.
     * @param BuilderInterface $builder
     * @param array $fields
     * @param string $placeholder
     * @throws \Exception
     */
    public function __construct(BuilderInterface $builder, array $fields, string $placeholder = '')
    {
        foreach ($fields as &$field) {
            $field = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createFieldExpression($field)->toString();
        }

        parent::__construct($builder, implode(static::GLUE, $fields), $placeholder);
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'GROUP BY %s';
    }
}