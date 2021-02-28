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
namespace GI\Filter\Simple\Collection;

use GI\Filter\AbstractFilter;

use GI\Meta\ClassMeta\Behaviour\Methods\MethodsInterface;
use GI\Meta\Method\MethodInterface;

abstract class AbstractCollectionFilter extends AbstractFilter implements CollectionFilterInterface
{
    const ITEMS_GETTER = 'getItems';


    /**
     * @return static
     * @throws \Exception
     */
    protected function validateInput()
    {
        if (!is_object($this->getInput())) {
            $this->giThrowInvalidTypeException('Filter collection input', $this->getInput(), 'object');
        }

        if (!$this->getInputMethodsMeta()->has(static::ITEMS_GETTER)) {
            $this->giThrowNotFoundException('Filter collection items getter', static::ITEMS_GETTER);
        }

        if (!is_array($this->getItems())) {
            $this->giThrowInvalidTypeException('Filter collection items', $this->getItems(), 'array');
        }

        return $this;
    }

    /**
     * @return MethodsInterface
     * @throws \Exception
     */
    protected function getInputMethodsMeta()
    {
        return $this->giGetClassMeta($this->getInput())->getMethods();
    }

    /**
     * @return MethodInterface
     * @throws \Exception
     */
    protected function getItemsMethodMeta()
    {
        return $this->getInputMethodsMeta()->get(static::ITEMS_GETTER);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getItems()
    {
        return $this->getItemsMethodMeta()->execute($this->getInput());
    }
}