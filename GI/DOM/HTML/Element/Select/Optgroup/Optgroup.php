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
namespace GI\DOM\HTML\Element\Select\Optgroup;

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\Select\Option\OptionList;

use GI\DOM\HTML\Element\Select\Option\OptionListInterface;

class Optgroup extends ContainerElement implements OptgroupInterface
{
    const TAG = 'optgroup';


    /**
     * @var OptionListInterface
     */
    private $childNodes;


    /**
     * Optgroup constructor.
     * @param string $label
     * @throws \Exception
     */
    public function __construct(string $label = '')
    {
        parent::__construct(static::TAG);

        $this->setLabel($label);
    }

    /**
     * @param string $label
     * @return static
     * @throws \Exception
     */
    public function setLabel(string $label)
    {
        $this->getAttributes()->set('label', $label);

        return $this;
    }

    /**
     * @return OptionListInterface
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createChildNodes()
    {
        $this->childNodes = $this->getGiServiceLocator()->getDependency(OptionListInterface::class, OptionList::class);

        return $this;
    }
}