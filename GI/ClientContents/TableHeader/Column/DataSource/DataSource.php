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
namespace GI\ClientContents\TableHeader\Column\DataSource;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Pattern\ArrayExchange\ExtractionInterface;

class DataSource implements DataSourceInterface
{
    use ServiceLocatorAwareTrait;


    const TYPE_DATA_ATTRIBUTE = 'data_attribute';

    const TYPE_ROW_NUMBER     = 'row_number';


    /**
     * @var string
     */
    private $dataAttribute = '';

    /**
     * @var string
     */
    private $type = '';


    /**
     * @return string
     */
    public function getDataAttribute()
    {
        return $this->dataAttribute;
    }

    /**
     * @param string $dataAttribute
     * @return static
     */
    public function setDataAttribute(string $dataAttribute)
    {
        $this->dataAttribute = $dataAttribute;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return static
     */
    protected function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return static
     */
    public function setTypeToDataAttribute()
    {
        $this->setType(self::TYPE_DATA_ATTRIBUTE);

        return $this;
    }

    /**
     * @return static
     */
    public function setTypeToRowNumber()
    {
        $this->setType(self::TYPE_ROW_NUMBER);

        return $this;
    }

    /**
     * @return bool
     */
    public function isTypeDataAttribute()
    {
        return $this->type == self::TYPE_DATA_ATTRIBUTE;
    }

    /**
     * @return bool
     */
    public function isTypeRowNumber()
    {
        return $this->type == self::TYPE_ROW_NUMBER;
    }

    /**
     * @param mixed $source
     * @param int $rowNumber
     * @return mixed
     * @throws \Exception
     */
    public function get($source, int $rowNumber)
    {
        return $this->isTypeDataAttribute() ? $this->getByDataAttribute($source) : $rowNumber;
    }

    /**
     * @param mixed $source
     * @return mixed
     * @throws \Exception
     */
    protected function getByDataAttribute($source)
    {
        if (!is_array($source) && !($source instanceof ExtractionInterface)) {
            $this->giThrowInvalidTypeException(
                'Source', print_r($source, true), 'Array or ExtractionInterface'
            );
        }

        if ($source instanceof ExtractionInterface) {
            $source = $source->extract();
        }

        if (!array_key_exists($this->dataAttribute, $source)) {
            $this->giThrowNotFoundException('Item', $this->dataAttribute);
        }

        return $source[$this->dataAttribute];
    }
}