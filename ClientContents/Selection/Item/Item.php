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
namespace GI\ClientContents\Selection\Item;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\Selection\ImmutableInterface;

class Item implements ItemInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ImmutableInterface
     */
    private $owner;

    /**
     * @var string
     */
    private $value = '';

    /**
     * @var string
     */
    private $text = '';

    /**
     * @var bool
     */
    private $selected = false;

    /**
     * @var mixed
     */
    private $contents;


    /**
     * Item constructor.
     * @param ImmutableInterface $owner
     * @param string $value
     * @param string $text
     * @param bool $selected
     */
    public function __construct(ImmutableInterface $owner, string $value, string $text, bool $selected = false)
    {
        $this->owner = $owner;
        $this->value = $value;
        $this->text  = $text;

        $this->setSelected($selected);
    }

    /**
     * @return ImmutableInterface
     */
    protected function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
        if ($selected && !$this->getOwner()->isMulti()) {
            $this->getOwner()->cleanSelections();
        }

        $this->selected = $selected;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param mixed $contents
     * @return static
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }
}