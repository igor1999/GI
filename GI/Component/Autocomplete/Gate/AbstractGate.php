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
namespace GI\Component\Autocomplete\Gate;

use GI\Component\Base\Gate\AbstractGate as Base;

use GI\Component\Autocomplete\AutocompleteInterface as ComponentInterface;

abstract class AbstractGate extends Base implements GateInterface
{
    /**
     * @var ComponentInterface
     */
    private $component;


    /**
     * @return ComponentInterface
     * @throws \Exception
     */
    protected function getComponent()
    {
        if (!($this->component instanceof ComponentInterface)) {
            $this->createComponent();
        }

        return $this->component;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createComponent()
    {
        try {
            $this->component = $this->giGetDi(ComponentInterface::class);
        } catch (\Exception $e) {
            $this->giThrowDependencyException(ComponentInterface::class);
        }

        return $this;
    }

    /**
     * get list of founded values
     */
    public function getList()
    {
        try {
            $data = $this->getCall()->getRequest()->getQuery()->extract();

            $response = $this->getComponent()->getList($data);

            $this->getCall()->setResponseToJSON($response);
         } catch (\Exception $e) {
            $this->getCall()->setResponseToStatus500($e->getMessage());
        }
    }
}