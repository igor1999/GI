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
namespace GI\ServiceLocator\Traits;

use GI\DOM\Factory\Factory as DOMFactory;
use GI\Component\Factory\Factory as ComponentFactory;

use GI\ServiceLocator\ServiceLocatorInterface;
use GI\DOM\Factory\FactoryInterface as DOMFactoryInterface;
use GI\Component\Factory\FactoryInterface as ComponentFactoryInterface;

trait ViewTrait
{
    /**
     * @var DOMFactoryInterface
     */
    private $domFactory;

    /**
     * @var ComponentFactoryInterface
     */
    private $componentFactory;


    /**
     * @param string|null $caller
     * @return DOMFactoryInterface
     */
    public function getDOMFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(DOMFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->domFactory instanceof DOMFactoryInterface)) {
                $this->domFactory = new DOMFactory();
            }

            $result = $this->domFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return ComponentFactoryInterface
     */
    public function getComponentFactory($caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(ComponentFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->componentFactory instanceof ComponentFactoryInterface)) {
                $this->componentFactory = new ComponentFactory();
            }

            $result = $this->componentFactory;
        }

        return $result;
    }
}