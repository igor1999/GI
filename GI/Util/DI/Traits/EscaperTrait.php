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
namespace GI\Util\DI\Traits;

use GI\Util\TextProcessing\Escaper\Factory\Factory\Factory as EscaperFactory;
use GI\Util\TextProcessing\Escaper\Factory\Container\Container as EscaperContainer;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\Escaper\Factory\Factory\FactoryInterface as EscaperFactoryInterface;
use GI\Util\TextProcessing\Escaper\Factory\Container\ContainerInterface as EscaperContainerInterface;

trait EscaperTrait
{
    /**
     * @var EscaperFactoryInterface
     */
    private $escaperFactory;


    /**
     * @param string|null $caller
     * @return EscaperFactoryInterface
     */
    public function getEscaperFactory(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(
                EscaperFactoryInterface::class, $caller
            );
        } catch (\Exception $e) {
            if (!($this->escaperFactory instanceof EscaperFactoryInterface)) {
                $this->escaperFactory = new EscaperFactory();
            }

            $result = $this->escaperFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return EscaperContainerInterface
     */
    public function createEscaperContainer(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(
                EscaperContainerInterface::class, $caller
            );
        } catch (\Exception $e) {
            $result = new EscaperContainer();
        }

        return $result;
    }
}