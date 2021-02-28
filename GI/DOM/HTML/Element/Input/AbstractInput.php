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
namespace GI\DOM\HTML\Element\Input;

use GI\DOM\HTML\Attributes\Attributes;
use GI\DOM\HTML\Element\SimpleElement;

use GI\DOM\HTML\Attributes\AttributesInterface;

abstract class AbstractInput extends SimpleElement implements InputInterface
{
    const TAG = 'input';


    const TYPE = null;


    /**
     * @var AttributesInterface
     */
    private $attributes;


    /**
     * AbstractInput constructor.
     * @param array $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __construct(array $name = [], $value = '')
    {
        parent::__construct(static::TAG);

        $this->getName()->setItems($name);

        $this->setValue($value);
    }

    /**
     * @return AttributesInterface
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createAttributes()
    {
        $this->attributes = $this->giGetDi(
            AttributesInterface::class, Attributes::class, [['type' => static::TYPE]]
        );

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->getAttributes()->getValue();
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value)
    {
        $this->getAttributes()->setValue($value);

        return $this;
    }

    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled)
    {
        $this->getAttributes()->setDisabled((bool)$disabled);

        return $this;
    }
}