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
namespace GI\DOM\Base\Attributes;

use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\Alterable as Base;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Storage\Collection\StringCollection\ArrayList\Alterable\AlterableInterface as StringArrayListInterface;
use GI\Storage\Collection\ScalarCollection\HashSet\Immutable\ImmutableInterface as ScalarHashSetInterface;

abstract class AbstractAttributes extends Base implements AttributesInterface
{
    use ServiceLocatorAwareTrait;


    const BOOL_ATTRIBUTE_RENDERING_PATTERN = '%s=""';

    const ATTRIBUTE_RENDERING_PATTERN      = '%s="%s"';


    /**
     * @var StringArrayListInterface
     */
    private $escapedAttributes;

    /**
     * @var ScalarHashSetInterface
     */
    private $constantAttributes;


    /**
     * AbstractAttributes constructor.
     * @param array $constantAttributes
     * @throws \Exception
     */
    public function __construct(array $constantAttributes = [])
    {
        $this->constantAttributes = $this->giGetStorageFactory()->createScalarHashSetImmutable($constantAttributes);

        $option = $this->giGetStorageFactory()->getOptionFactory()->createScalarHashSet();
        $option->setKeyFormatToHyphenLowerCase()->setValueFormatToHyphenLowerCase();
        parent::__construct([], $option);

        $this->escapedAttributes = $this->giGetStorageFactory()->createStringArrayListAlterable();

        $this->createEscaper();
    }

    /**
     * @return static
     */
    abstract protected function createEscaper();

    /**
     * @return ScalarHashSetInterface
     */
    public function getConstantAttributes()
    {
        return $this->constantAttributes;
    }

    /**
     * @param string $key
     * @param string|bool $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function set(string $key, $item, int $position = null)
    {
        if ($this->getConstantAttributes()->has($key)) {
            $this->giThrowCommonException('Attribute \'%s\' is constant', [$key]);
        }

        parent::set($key, $item);

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function remove(string $key)
    {
        if ($this->getConstantAttributes()->has($key)) {
            $this->giThrowCommonException('Attribute \'%s\' is constant', [$key]);
        }

        return parent::remove($key);
    }

    /**
     * @return StringArrayListInterface
     */
    public function getEscapedAttributes()
    {
        return $this->escapedAttributes;
    }

    /**
     * @param string $attribute
     * @param string $value
     * @return string
     */
    protected function escapeAttribute(string $attribute, string $value)
    {
        return $this->getEscapedAttributes()->contains($attribute) ? $this->getEscaper()->escape($value) : $value;
    }

    /**
     * @return array
     */
    protected function getItemsWithConstantAttributes()
    {
        return array_merge($this->getItems(), $this->getConstantAttributes()->getItems());
    }

    /**
     * @return string
     */
    public function toString()
    {
        $output = [];

        foreach ($this->getItemsWithConstantAttributes() as $key => $value) {
            if ($value === true) {
                $output[] = sprintf(static::BOOL_ATTRIBUTE_RENDERING_PATTERN, $key);
            } elseif (!is_bool($value)) {
                $value = $this->escapeAttribute($key, (string)$value);
                $output[] = sprintf(static::ATTRIBUTE_RENDERING_PATTERN, $key, $value);
            }
        }

        return !empty($output) ? implode(' ', $output) : '';
    }
}