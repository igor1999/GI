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
namespace GI\RDB\Meta\Column;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ExtractionTrait;

use GI\RDB\Meta\Table\TableInterface;

class Column implements ColumnInterface
{
    use ServiceLocatorAwareTrait, ExtractionTrait;


    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var int
     */
    private $index = -1;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var mixed
     */
    private $default;

    /**
     * @var bool
     */
    private $primary = false;

    /**
     * @var bool
     */
    private $null = true;


    /**
     * Column constructor.
     * @param TableInterface $table
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(TableInterface $table, array $contents)
    {
        $this->table = $table;

        $this->giGetClassMeta()->getMethods()->hydrate($this, $contents)->validate($this);
    }

    /**
     * @return TableInterface
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @extract
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @hydrate
     * @param int $index
     * @return static
     */
    protected function setIndex($index)
    {
        $this->index = (int)$index;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateIndex()
    {
        if ($this->index < 0) {
            $this->giThrowInvalidMinimumException('Column index', $this->index, 'not negative number');
        }
    }

    /**
     * @extract
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFullQualifiedName()
    {
        return $this->getTable()->getDriver()->getPlatform()->joinEntities(
            [$this->getTable()->getFullName(), $this->name]
        );
    }

    /**
     * @hydrate
     * @param string $name
     * @return static
     */
    protected function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateName()
    {
        if (empty($this->name)) {
            $this->giThrowIsEmptyException('Column name');
        }
    }

    /**
     * @extract
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @hydrate
     * @param string $type
     * @return static
     */
    protected function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateType()
    {
        if (empty($this->type)) {
            $this->giThrowIsEmptyException('Column type');
        }
    }

    /**
     * @extract
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @hydrate
     * @param mixed $default
     * @return static
     */
    protected function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @extract
     * @return bool
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @hydrate
     * @param bool $primary
     * @return static
     */
    protected function setPrimary($primary)
    {
        $this->primary = (bool)$primary;

        return $this;
    }

    /**
     * @extract
     * @return bool
     */
    public function isNull()
    {
        return $this->null;
    }

    /**
     * @hydrate
     * @param bool $null
     * @return static
     */
    protected function setNull($null)
    {
        $this->null = (bool)$null;

        return $this;
    }
}