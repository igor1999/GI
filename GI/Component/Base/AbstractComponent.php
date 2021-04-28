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
namespace GI\Component\Base;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Base\View\ClientAttributes\ClientAttributesInterface;

abstract class AbstractComponent implements ComponentInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @return ClientAttributesInterface
     */
    abstract protected function getView();

    /**
     * @return string
     */
    public function getViewClientJSObject()
    {
        return $this->getView()->getClientJSObject();
    }

    /**
     * @return string
     */
    public function getViewCommonForId()
    {
        return $this->getView()->createCommonFormId();
    }

    /**
     * @param ComponentInterface $component
     * @return static
     */
    public function addExternalFormIdToView(ComponentInterface $component)
    {
        $this->getView()->setExternFormId($component->getViewCommonForId());

        return $this;
    }
}