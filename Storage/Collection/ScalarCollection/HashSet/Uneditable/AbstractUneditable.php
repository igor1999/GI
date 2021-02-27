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
namespace GI\Storage\Collection\ScalarCollection\HashSet\Uneditable;

use GI\Storage\Collection\ScalarCollection\HashSet\Immutable\Immutable;

abstract class AbstractUneditable extends Immutable implements UneditableInterface
{
    /**
     * @param string $key
     * @param mixed $item
     * @return static
     * @throws \Exception
     */
    protected function edit(string $key, $item)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        $this->set($key, $item);

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return bool|mixed|self
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        $result = null;

        try {
            list($set, $value) = $this->giGetPSRFormatParser()->parseSetterWithValue($method);
        } catch (\Exception $exception) {
            try {
                $set = $this->giGetPSRFormatParser()->parseWithPrefixSet($method);
            } catch (\Exception $exception) {
                $result = parent::__call($method, $arguments);
            }
        }

        if (!empty($set) && !empty($value)) {
            $set    = $this->getService()->formatKey($set);
            $value  = $this->getService()->formatValue($value);
            $result = $this->edit($set, $value);
        } elseif (!empty($set)) {
            if (empty($arguments)) {
                $this->giThrowNotGivenException('Argument for set');
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
     * @param mixed|null $value
     * @return static
     * @throws \Exception
     */
    public function reset($value = null)
    {
        return parent::reset($value);
    }
}