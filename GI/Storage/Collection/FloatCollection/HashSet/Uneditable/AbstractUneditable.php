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
namespace GI\Storage\Collection\FloatCollection\HashSet\Uneditable;

use GI\Storage\Collection\FloatCollection\HashSet\Immutable\Immutable;

abstract class AbstractUneditable extends Immutable implements UneditableInterface
{
    /**
     * @param string $key
     * @param float $item
     * @return static
     * @throws \Exception
     */
    protected function edit(string $key, float $item)
    {
        if (!$this->has($key)) {
            $this->getGiServiceLocator()->throwNotInScopeException($key);
        }

        $this->set($key, $item);

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return bool|float|self
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        $result = null;

        try {
            $set = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixSet($method);
        } catch (\Exception $exception) {
            $result = parent::__call($method, $arguments);
        }

        if (!empty($set)) {
            if (empty($arguments)) {
                $this->getGiServiceLocator()->throwNotGivenException('Argument for set');
            }
            $set = $this->getService()->formatKey($set);
            $result = $this->edit($set, array_shift($arguments));
        }

        return $result;
    }

    /**
     * @param \Closure $f
     * @return static
     * @throws \Exception
     */
    public function map(\Closure $f)
    {
        return parent::map($f);
    }

    /**
     * @param float $value
     * @return static
     * @throws \Exception
     */
    public function reset(float $value = 0.0)
    {
        return parent::reset($value);
    }
}