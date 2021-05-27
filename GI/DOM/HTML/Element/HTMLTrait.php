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
namespace GI\DOM\HTML\Element;

use GI\DOM\HTML\Attributes\Attributes;
use GI\DOM\HTML\Attributes\Classes\Classes;
use GI\DOM\HTML\Attributes\Name\Name;
use GI\DOM\HTML\Attributes\Style\Style;

use GI\DOM\HTML\Attributes\AttributesInterface;
use GI\DOM\HTML\Attributes\Classes\ClassesInterface;
use GI\DOM\HTML\Attributes\Name\NameInterface;
use GI\DOM\HTML\Attributes\Style\StyleInterface;

trait HTMLTrait
{
    /**
     * @var AttributesInterface
     */
    private $attributes;

    /**
     * @var NameInterface
     */
    private $name;

    /**
     * @var ClassesInterface
     */
    private $classes;

    /**
     * @var StyleInterface
     */
    private $style;


    /**
     * @return AttributesInterface
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return static
     */
    protected function createAttributes()
    {
        $this->attributes = $this->giGetDi(AttributesInterface::class, Attributes::class);

        return $this;
    }

    /**
     * @return NameInterface
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return static
     */
    protected function createName()
    {
        $this->name = $this->giGetDi(NameInterface::class, Name::class);

        return $this;
    }

    /**
     * @return ClassesInterface
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @return static
     */
    protected function createClasses()
    {
        $this->classes = $this->giGetDi(ClassesInterface::class, Classes::class);

        return $this;
    }

    /**
     * @return StyleInterface
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @return static
     */
    protected function createStyle()
    {
        $this->style = $this->giGetDi(StyleInterface::class, Style::class);

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getContents()
    {
        return trim(
            $this->getAttributes()->toString()
            . ' '. $this->getName()->toString()
            . ' ' . $this->getClasses()->toString()
            . ' ' . $this->getStyle()->toString()
        );
    }

    /**
     * @return static
     */
    public function show()
    {
        $this->getStyle()->setDisplayToBlock();

        return $this;
    }

    /**
     * @return static
     */
    public function hide()
    {
        $this->getStyle()->setDisplayToNone();

        return $this;
    }

    /**
     * @param bool $visible
     * @return static
     */
    public function setVisibility(bool $visible)
    {
        if ($visible) {
            $this->show();
        } else {
            $this->hide();
        }

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getGIId()
    {
        return $this->getAttributes()->getDataAttribute(self::ATTRIBUTE_GI_ID);
    }

    /**
     * @param string $giId
     * @return static
     * @throws \Exception
     */
    public function setGIId(string $giId)
    {
        $this->getAttributes()->setDataAttribute(self::ATTRIBUTE_GI_ID, $giId);

        return $this;
    }
}