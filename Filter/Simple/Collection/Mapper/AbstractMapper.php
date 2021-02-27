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
namespace GI\Filter\Simple\Collection\Mapper;

use GI\Filter\Simple\Collection\AbstractCollectionFilter;

abstract class AbstractMapper extends AbstractCollectionFilter implements MapperInterface
{
    const SETTER_METHOD = 'set';


    /**
     * @return mixed
     * @throws \Exception
     */
    public function execute()
    {
        $this->validateInput();

        foreach ($this->getItems() as $key => $item) {
            $value = $this->map($key, $item);
            $this->getInputMethodsMeta()->get(static::SETTER_METHOD)->execute($this->getInput(), [$key, $value]);
        }

        return $this->getInput();
    }

    /**
     * @param string|int $key
     * @param mixed $item
     * @return mixed
     */
    abstract protected function map($key, $item);
}