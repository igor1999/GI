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
namespace GI\RDB\ORM\Set\Index\Collection;

use GI\Pattern\Factory\AbstractFactory;

use GI\RDB\ORM\Set\Index\IndexInterface;
use GI\RDB\ORM\Set\SetInterface;

class Collection extends AbstractFactory implements CollectionInterface
{
    /**
     * @var SetInterface
     */
    private $set;


    /**
     * Collection constructor.
     * @param SetInterface $set
     */
    public function __construct(SetInterface $set)
    {
        $this->setCached(true)->setPrefixToGet();

        $this->set = $set;
    }

    /**
     * @return SetInterface
     */
    protected function getSet()
    {
        return $this->set;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @param string $prefix
     * @return IndexInterface
     * @throws \Exception
     */
    public function create(string $method, array $arguments = [], string $prefix = '')
    {
        $arguments = [$this->getSet()];

        return parent::create($method, $arguments, $prefix);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function refresh()
    {
        foreach ($this->getItems() as $item) {
            /** @var IndexInterface $index */
            $index = $item->get([]);

            $index->refresh();
        }

        return $this;
    }
}