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
namespace GI\ClientContents\Menu\Option;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\ClientContents\NavigationNode\NavigationNodeTrait;

use GI\ClientContents\Menu\MenuInterface;

class Option implements OptionInterface
{
    use ServiceLocatorAwareTrait, NavigationNodeTrait;


    const ID_SEPARATOR = '/';


    /**
     * @var MenuInterface
     */
    private $container;

    /**
     * @var string
     */
    private $localID = '';

    /**
     * @var MenuInterface
     */
    private $popup;

    /**
     * @var bool
     */
    private $disabled = false;

    /**
     * @var bool
     */
    private $hidden = false;

    /**
     * @var bool
     */
    private $selected = false;


    /**
     * Option constructor.
     * @param MenuInterface $container
     * @param string $localID
     */
    public function __construct(MenuInterface $container, string $localID)
    {
        $this->container = $container;
        $this->localID   = $localID;
    }

    /**
     * @return bool
     */
    public function hasContainer()
    {
        return $this->container instanceof MenuInterface;
    }

    /**
     * @return MenuInterface
     * @throws \Exception
     */
    public function getContainer()
    {
        if (!$this->hasContainer()) {
            $this->getGiServiceLocator()->throwNotSetException('Option container');
        }

        return $this->container;
    }

    /**
     * @return string
     */
    public function getLocalID()
    {
        return $this->localID;
    }

    /**
     * @return string
     */
    public function getGlobalID()
    {
        try {
            $id = $this->getContainer()->getOpener()->getGlobalID() . static::ID_SEPARATOR . $this->localID;
        } catch (\Exception $e) {
            $id = $this->getLocalID();
        }

        return $id;
    }

    /**
     * @return bool
     */
    public function hasPopup()
    {
        return $this->popup instanceof MenuInterface;
    }

    /**
     * @return MenuInterface
     * @throws \Exception
     */
    public function getPopup()
    {
        if (!$this->hasPopup()) {
            $this->getGiServiceLocator()->throwNotSetException('Popup');
        }

        return $this->popup;
    }

    /**
     * @param MenuInterface $popup
     * @return static
     * @throws \Exception
     */
    public function setPopup(MenuInterface $popup)
    {
        if ($this->hasPopup()) {
            $this->getGiServiceLocator()->throwAlreadySetException('Popup');
        }

        $this->popup = $popup;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     * @return static
     */
    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSelected()
    {
        return $this->selected;
    }

    /**
     * @param bool $selected
     * @return static
     */
    public function setSelected(bool $selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * @param bool $selected
     * @return static
     */
    public function selectRecursive(bool $selected)
    {
        $this->setSelected($selected);

        try {
            $this->getContainer()->getOpener()->selectRecursive($selected);
        } catch (\Exception $exception) {

        }

        return $this;
    }
}