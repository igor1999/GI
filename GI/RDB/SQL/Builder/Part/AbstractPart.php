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
namespace GI\RDB\SQL\Builder\Part;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\SQL\Builder\BuilderInterface;

abstract class AbstractPart implements PartInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_PLACEHOLDER = '';

    const DEFAULT_EMPTY_VALUE = '';


    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var string
     */
    private $placeholder = '';

    /**
     * @var string|mixed
     */
    private $value;


    /**
     * AbstractPart constructor.
     * @param BuilderInterface $builder
     * @param mixed|string $value
     * @param string $placeholder
     */
    public function __construct(BuilderInterface $builder, $value, string $placeholder = '')
    {
        $this->builder     = $builder;
        $this->value       = $value;
        $this->placeholder = empty($placeholder) ? static::DEFAULT_PLACEHOLDER : $placeholder;
    }

    /**
     * @return BuilderInterface
     */
    protected function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     * @return static
     */
    protected function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|string $value
     * @return static
     */
    protected function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getTemplate();

    /**
     * @return static
     * @throws \Exception
     */
    public function build()
    {
        $placeholder = $this->giGetSqlFactory()->createPlaceholderExpression($this->placeholder);

        $value = $this->validate() ? $this->compile() : static::DEFAULT_EMPTY_VALUE;

        $template = str_replace($placeholder->toString(), $value, $this->getBuilder()->getTemplate());

        $this->getBuilder()->setTemplate($template);

        return $this;
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        return !empty($this->value);
    }

    /**
     * @return string
     */
    protected function compile()
    {
        return sprintf($this->getTemplate(), $this->value);
    }
}