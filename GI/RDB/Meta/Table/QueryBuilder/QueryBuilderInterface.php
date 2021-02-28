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
namespace GI\RDB\Meta\Table\QueryBuilder;

use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;

interface QueryBuilderInterface
{

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function insert(array $contents, SQLBuilderInterface $builder = null);

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function delete(array $contents, SQLBuilderInterface $builder = null);

    /**
     * @param array $values
     * @param array $conditions
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function update(array $values, array $conditions, SQLBuilderInterface $builder = null);

    /**
     * @param array $contents
     * @param string|null $order
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function select(array $contents, $order = null, SQLBuilderInterface $builder = null);
}