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
namespace GI\Meta\CopyMaker;

use GI\Meta\CopyMaker\Registry\Registry;
use GI\Meta\CopyMaker\Contents\Contents;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\CopyMaker\Registry\RegistryInterface;
use GI\Meta\CopyMaker\Contents\ContentsInterface;

class CopyMaker implements CopyMakerInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var ContentsInterface
     */
    private $contents;


    /**
     * CopyMaker constructor.
     */
    public function __construct()
    {
        $this->registry = $this->createRegistry();
        $this->contents = $this->createContents();
    }

    /**
     * @return RegistryInterface
     */
    protected function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @return Registry
     */
    protected function createRegistry()
    {
        return new Registry();
    }

    /**
     * @return ContentsInterface
     */
    protected function getContents()
    {
        return $this->contents;
    }

    /**
     * @return Contents
     */
    protected function createContents()
    {
        return new Contents($this->getRegistry());
    }

    /**
     * @param \Closure|null $encoder
     * @return static
     */
    public function setClassEncoder(\Closure $encoder = null)
    {
        $this->getContents()->setClassEncoder($encoder);

        return $this;
    }

    /**
     * @param \Closure|null $decoder
     * @return static
     */
    public function setClassDecoder(\Closure $decoder = null)
    {
        $this->getContents()->setClassDecoder($decoder);

        return $this;
    }

    /**
     * @param mixed $source
     * @return mixed
     * @throws \Exception
     */
    public function expand($source)
    {
        $this->getRegistry()->clean();

        return $this->processExpand($source);
    }

    /**
     * @param mixed $source
     * @return mixed
     * @throws \Exception
     */
    protected function processExpand($source)
    {
        if (is_array($source)) {
            $f = function($item)
            {
                return $this->processExpand($item);
            };
            $result = array_map($f, $source);
        } elseif (is_object($source)) {
            $this->getContents()->fill($source);
            $result = [self::OBJECT_CONTENTS_ELEMENT => $this->getContents()->extract()];

            if (!$this->getContents()->isRegistered()) {
                $this->getRegistry()->add($source);

                $properties = $this->getGiServiceLocator()->getClassMeta($source)->getProperties();
                foreach ($properties->getItems() as $name => $property) {
                    $result[$name] = $this->processExpand($property->getValue($source));
                }
            }
        } else {
            $result = $source;
        }

        return $result;
    }

    /**
     * @param mixed $contents
     * @return mixed
     * @throws \Exception
     */
    public function fold($contents)
    {
        $this->getRegistry()->clean();

        return $this->processFold($contents);
    }

    /**
     * @param mixed $contents
     * @return array|object
     * @throws \Exception
     */
    protected function processFold($contents)
    {
        if (is_array($contents) && array_key_exists(self::OBJECT_CONTENTS_ELEMENT, $contents)) {
            if (!is_array($contents[self::OBJECT_CONTENTS_ELEMENT])) {
                $this->getGiServiceLocator()->throwInvalidTypeException(
                    'Object contents item', $contents[self::OBJECT_CONTENTS_ELEMENT], 'array'
                );
            }

            $this->getContents()->resetAndHydrate($contents[self::OBJECT_CONTENTS_ELEMENT])->validateProperties();

            if ($this->getContents()->isRegistered()) {
                $result = $this->getRegistry()->get($this->getContents()->getHash());
            } else {
                $reflection = $this->getGiServiceLocator()->getClassMeta($this->getContents()->getClass());
                $result     = $reflection->getReflection()->newInstanceWithoutConstructor();
                $this->getRegistry()->set($this->getContents()->getHash(), $result);
                foreach ($reflection->getProperties()->getItems() as $name => $property) {
                    if (array_key_exists($name, $contents)) {
                        $property->setValue($result, $this->processFold($contents[$name]));
                    }
                }
            }
        } elseif (is_array($contents)) {
            $f = function($item)
            {
                return $this->processFold($item);
            };
            $result = array_map($f, $contents);
        } else {
            $result = $contents;
        }

        return $result;
    }

    /**
     * @param mixed $source
     * @return mixed
     * @throws \Exception
     */
    public function makeCopy($source)
    {
        return $this->fold($this->expand($source));
    }
}