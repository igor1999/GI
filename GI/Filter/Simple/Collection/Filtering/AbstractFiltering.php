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
namespace GI\Filter\Simple\Collection\Filtering;

use GI\Filter\Simple\Collection\AbstractCollectionFilter;

abstract class AbstractFiltering extends AbstractCollectionFilter implements FilteringInterface
{
    const REMOVE_METHOD  = 'remove';


    /**
     * @return mixed
     * @throws \Exception
     */
    public function execute()
    {
        $this->validateInput();

        foreach (array_reverse($this->getItems(), true) as $key => $item) {
            if (!$this->filter($key, $item)) {
                $this->getInputMethodsMeta()->get(static::REMOVE_METHOD)->execute($this->getInput(), [$key]);
            }
        }

        return $this->getInput();
    }

    /**
     * @param string|int $key
     * @param mixed $item
     * @return bool
     */
    abstract protected function filter($key, $item);
}