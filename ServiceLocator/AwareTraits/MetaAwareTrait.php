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
namespace GI\ServiceLocator\AwareTraits;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\MetaInterface;
use GI\Meta\ClassMeta\ClassMetaInterface;

trait MetaAwareTrait
{
    /**
     * @return MetaInterface
     */
    protected function giGetMeta()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getMeta();
    }

    /**
     * @param mixed|null $source
     * @return ClassMetaInterface
     * @throws \Exception
     */
    protected function giGetClassMeta($source = null)
    {
        if (empty($source)) {
            $source = static::class;
        }

        return $this->giGetMeta()->getClassMeta($source);
    }

    /**
     * @param string|null $descriptor
     * @return array
     * @throws \Exception
     */
    protected function giExtract(string $descriptor = null)
    {
        return $this->giGetClassMeta()->extract($this, $descriptor);
    }

    /**
     * @param array $data
     * @param string|null $descriptor
     * @return static
     * @throws \Exception
     */
    protected function giHydrate(array $data, string $descriptor = null)
    {
        $this->giGetClassMeta()->hydrate($this, $data, $descriptor);

        return $this;
    }

    /**
     * @param string|null $descriptor
     * @return static
     * @throws \Exception
     */
    protected function giValidate(string $descriptor = null)
    {
        $this->giGetClassMeta()->getMethods()->validate($this, $descriptor);

        return $this;
    }
}