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
namespace GI\RDB\Meta\Table\PHPNames;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Meta\Table\TableInterface;

class PHPNames implements PHPNamesInterface
{
    use ServiceLocatorAwareTrait;


    const ALIAS_SEPARATOR = '_';


    const RECORD_SUFFIX    = 'Record';

    const SET_SUFFIX       = 'Set';

    const INTERFACE_SUFFIX = 'Interface';


    /**
     * @var TableInterface
     */
    private $table;


    /**
     * PHPNames constructor.
     * @param TableInterface $table
     */
    public function __construct(TableInterface $table)
    {
        $this->table = $table;
    }

    /**
     * @return TableInterface
     */
    protected function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getSchemaNamespace()
    {
        return $this->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertUnderlineToCamelCaseUpperFirst($this->getTable()->getSchema());
    }

    /**
     * @return string
     */
    public function getLocalNamespace()
    {
        return $this->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertUnderlineToCamelCaseUpperFirst(
            $this->getTable()->getLocalName()
        );
    }

    /**
     * @return array
     */
    protected function getNamespaces()
    {
        return array_filter([$this->getSchemaNamespace(), $this->getLocalNamespace()]);
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return implode('\\', $this->getNamespaces());
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return implode('/', $this->getNamespaces());
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return implode(static::ALIAS_SEPARATOR, $this->getNamespaces());
    }

    /**
     * @return string
     */
    public function getRecordClass()
    {
        return $this->getNamespace() . '\\' . static::RECORD_SUFFIX;
    }

    /**
     * @return string
     */
    public function getRecordInterface()
    {
        return $this->getRecordClass() . static::INTERFACE_SUFFIX;
    }

    /**
     * @return string
     */
    public function getSetClass()
    {
        return $this->getNamespace() . '\\' . static::SET_SUFFIX;
    }

    /**
     * @return string
     */
    public function getSetInterface()
    {
        return $this->getSetClass() . static::INTERFACE_SUFFIX;
    }

    /**
     * @return string
     */
    public function getRecordClassAlias()
    {
        return $this->getAlias() . static::RECORD_SUFFIX;
    }

    /**
     * @return string
     */
    public function getRecordInterfaceAlias()
    {
        return $this->getRecordClassAlias() . static::INTERFACE_SUFFIX;
    }

    /**
     * @return string
     */
    public function getSetClassAlias()
    {
        return $this->getAlias() . static::SET_SUFFIX;
    }

    /**
     * @return string
     */
    public function getSetInterfaceAlias()
    {
        return $this->getSetClassAlias() . static::INTERFACE_SUFFIX;
    }

    /**
     * @return string
     */
    public function getRecordProperty()
    {
        return lcfirst($this->getAlias());
    }

    /**
     * @return string
     */
    public function getSetProperty()
    {
        return $this->getRecordProperty() . static::SET_SUFFIX;
    }

    /**
     * @return string
     */
    public function getRecordGetter()
    {
        $getter = $this->getAlias();

        return $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildGet($getter);
    }

    /**
     * @return string
     */
    public function getRecordCreator()
    {
        $creator = $this->getAlias();

        return $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildCreate($creator);
    }

    /**
     * @return string
     */
    public function getSetGetter()
    {
        return $this->getRecordGetter() . static::SET_SUFFIX;
    }

    /**
     * @return string
     */
    public function getSetCreator()
    {
        return $this->getRecordCreator() . static::SET_SUFFIX;
    }
}